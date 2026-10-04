<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        require_once APP_DIR . 'helpers/api_helper.php';
        $this->call->database();
        $this->call->library('api');
    }

    public function options()
    {
        http_response_code(204);
    }

    public function health()
    {
        $this->db->raw('SELECT 1')->fetchColumn();
        $this->api->respond(['status' => 'ok']);
    }

    public function login()
    {
        $remote_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $this->api->rate_limit('login:' . $remote_address, 10, 60);

        $input = $this->json_body();
        $identifier = $input['identifier'] ?? $input['username'] ?? null;
        $password = $input['password'] ?? null;

        if (!is_string($identifier) || trim($identifier) === ''
            || strlen($identifier) > 255 || !is_string($password)
            || $password === '' || strlen($password) > 4096) {
            $this->api->respond_error('Username/email and password are required.', 422);
        }
        $identifier = trim($identifier);

        $stmt = $this->db->raw(
            'SELECT id, username, email, password, role FROM users
             WHERE (username = ? OR email = ?) AND is_active = 1 LIMIT 1',
            [$identifier, $identifier]
        );
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->api->respond_error('Invalid username/email or password.', 401);
        }

        $tokens = $this->api->issue_tokens([
            'id'     => $user['id'],
            'role'   => $user['role'],
            'scopes' => ['read', 'write', 'delete'],
        ]);

        unset($user['password']);
        $this->api->respond([
            'user'   => $user,
            'tokens' => $tokens,
        ]);
    }

    public function register()
    {
        $remote_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $this->api->rate_limit('register:' . $remote_address, 5, 60);

        $input = $this->json_body();
        $username = $input['username'] ?? null;
        $email = $input['email'] ?? null;
        $password = $input['password'] ?? null;

        if (!is_string($username)
            || !preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $username)) {
            $this->api->respond_error(
                'Username must be 3-50 characters and use only letters, numbers, dots, underscores, or hyphens.',
                422
            );
        }

        if (!is_string($email) || strlen($email) > 255
            || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->api->respond_error('Enter a valid email address.', 422);
        }

        if (!is_string($password) || strlen($password) < 12 || strlen($password) > 72) {
            $this->api->respond_error('Password must be between 12 and 72 bytes.', 422);
        }

        $existing = $this->db->raw(
            'SELECT username, email FROM users WHERE username = ? OR email = ? LIMIT 1',
            [$username, $email]
        )->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $field = $existing['username'] === $username ? 'Username' : 'Email';
            $this->api->respond_error("{$field} is already registered.", 409);
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        if ($password_hash === false) {
            throw new RuntimeException('Unable to securely hash the account password.');
        }

        $this->db->raw(
            'INSERT INTO users (username, email, password, role, is_active)
             VALUES (?, ?, ?, ?, ?)',
            [$username, $email, $password_hash, 'user', 1]
        );
        $user_id = (int) $this->db->raw('SELECT LAST_INSERT_ID()')->fetchColumn();

        $tokens = $this->api->issue_tokens([
            'id'     => $user_id,
            'role'   => 'user',
            'scopes' => ['read'],
        ]);

        $this->api->respond([
            'user' => [
                'id'       => $user_id,
                'username' => $username,
                'email'    => $email,
                'role'     => 'user',
            ],
            'tokens' => $tokens,
        ], 201);
    }

    public function refresh()
    {
        $input = $this->json_body();
        $refresh_token = $input['refresh_token'] ?? '';

        if (!is_string($refresh_token) || $refresh_token === '') {
            $this->api->respond_error('Refresh token is required.', 422);
        }

        $this->api->refresh_access_token($refresh_token);
    }

    public function logout()
    {
        $this->api->require_jwt();

        $input = $this->json_body();
        $refresh_token = $input['refresh_token'] ?? '';

        if (is_string($refresh_token) && $refresh_token !== '') {
            $payload = $this->api->validate_jwt($refresh_token, 'refresh');
            if ($payload) {
                $this->api->revoke_refresh_token($refresh_token);
            }
        }

        $this->api->respond(['message' => 'Logged out successfully.']);
    }

    public function products()
    {
        $this->api->require_jwt();
        $stmt = $this->db->raw(
            'SELECT id, product_name, description, price, quantity, created_at
             FROM products ORDER BY id DESC'
        );
        $this->api->respond(['data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    }

    public function product($id)
    {
        $this->api->require_jwt();
        $product_id = $this->validated_id($id);
        $stmt = $this->db->raw(
            'SELECT id, product_name, description, price, quantity, created_at
             FROM products WHERE id = ? LIMIT 1',
            [$product_id]
        );
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->api->respond(['data' => $product]);
    }

    public function create_product()
    {
        $this->api->require_jwt();
        $input = $this->validated_product($this->json_body());

        $this->db->raw(
            'INSERT INTO products (product_name, description, price, quantity)
             VALUES (?, ?, ?, ?)',
            [
                $input['product_name'],
                $input['description'],
                $input['price'],
                $input['quantity'],
            ]
        );
        $id = (int) $this->db->raw('SELECT LAST_INSERT_ID()')->fetchColumn();
        $product = $this->fetch_product($id);

        $this->api->respond(['data' => $product], 201);
    }

    public function update_product($id)
    {
        $this->api->require_jwt();
        $product_id = $this->validated_id($id);
        $existing = $this->fetch_product($product_id);

        if (!$existing) {
            $this->api->respond_error('Product not found.', 404);
        }

        $input = $this->json_body();
        if (($_SERVER['REQUEST_METHOD'] ?? 'PUT') === 'PUT') {
            foreach (['product_name', 'description', 'price', 'quantity'] as $field) {
                if (!array_key_exists($field, $input)) {
                    $this->api->respond_error("Field '{$field}' is required for PUT.", 422);
                }
            }
        }

        $fields = $this->validated_product($input, true);
        if (!$fields) {
            $this->api->respond_error('At least one product field is required.', 422);
        }

        $allowed_fields = ['product_name', 'description', 'price', 'quantity'];
        foreach (array_keys($fields) as $field) {
            if (!in_array($field, $allowed_fields, true)) {
                $this->api->respond_error('Unsupported product field.', 422);
            }
        }

        $assignments = [];
        $values = [];
        foreach ($fields as $field => $value) {
            $assignments[] = "`{$field}` = ?";
            $values[] = $value;
        }
        $values[] = $product_id;

        $this->db->raw(
            'UPDATE products SET ' . implode(', ', $assignments) . ' WHERE id = ?',
            $values
        );

        $this->api->respond(['data' => $this->fetch_product($product_id)]);
    }

    public function delete_product($id)
    {
        $this->api->require_jwt();
        $product_id = $this->validated_id($id);
        $stmt = $this->db->raw('DELETE FROM products WHERE id = ?', [$product_id]);

        if ($stmt->rowCount() === 0) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->api->respond(['message' => 'Product deleted successfully.']);
    }

    private function json_body()
    {
        $raw = (string) file_get_contents('php://input');
        if (strlen($raw) > 70000) {
            $this->api->respond_error('Request body is too large.', 413);
        }

        $input = json_decode($raw, true);

        if (!is_array($input) || json_last_error() !== JSON_ERROR_NONE) {
            $this->api->respond_error('A valid JSON object is required.', 400);
        }

        return $input;
    }

    private function validated_id($id)
    {
        $product_id = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($product_id === false) {
            $this->api->respond_error('Product ID must be a positive integer.', 422);
        }

        return $product_id;
    }

    private function validated_product(array $input, $partial = false)
    {
        $allowed = ['product_name', 'description', 'price', 'quantity'];
        foreach (array_keys($input) as $field) {
            if (!in_array($field, $allowed, true)) {
                $this->api->respond_error("Unsupported product field: {$field}.", 422);
            }
        }

        $fields = [];

        if (!$partial || array_key_exists('product_name', $input)) {
            $name = $input['product_name'] ?? null;
            if (!is_string($name) || trim($name) === '' || strlen(trim($name)) > 100) {
                $this->api->respond_error('Product name is required and must be 100 characters or fewer.', 422);
            }
            $fields['product_name'] = trim($name);
        }

        if (!$partial || array_key_exists('description', $input)) {
            $description = $input['description'] ?? '';
            if ($description !== null && (!is_string($description) || strlen($description) > 65535)) {
                $this->api->respond_error('Description must be 65,535 bytes or fewer.', 422);
            }
            $fields['description'] = $description;
        }

        if (!$partial || array_key_exists('price', $input)) {
            $price = $input['price'] ?? null;
            if ((!is_string($price) && !is_int($price) && !is_float($price))
                || !preg_match('/^\d{1,8}(?:\.\d{1,2})?$/', (string) $price)) {
                $this->api->respond_error('Price must be a non-negative amount with up to 2 decimal places.', 422);
            }
            $fields['price'] = (string) $price;
        }

        if (!$partial || array_key_exists('quantity', $input)) {
            $quantity = $input['quantity'] ?? null;
            $validated_quantity = filter_var(
                $quantity,
                FILTER_VALIDATE_INT,
                ['options' => ['min_range' => 0, 'max_range' => 2147483647]]
            );
            if ($validated_quantity === false) {
                $this->api->respond_error('Quantity must be a non-negative integer.', 422);
            }
            $fields['quantity'] = $validated_quantity;
        }

        return $fields;
    }

    private function fetch_product($id)
    {
        return $this->db->raw(
            'SELECT id, product_name, description, price, quantity, created_at
             FROM products WHERE id = ? LIMIT 1',
            [$id]
        )->fetch(PDO::FETCH_ASSOC);
    }
}
