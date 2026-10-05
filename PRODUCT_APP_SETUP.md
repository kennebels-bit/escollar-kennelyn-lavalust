# Product Desk setup and deployment

This is a separate React frontend for the existing LavaLust application. It uses the JWT-enabled LavaLust API and Aiven MySQL; it does not connect to MySQL from the browser. The existing `ProductController`, `ProductModel`, and product views are not used or modified by this frontend. The API stores records in separate `api_products` and `api_users` tables; migration 005 copies the current records from the legacy `products` and `users` tables without deleting or changing the legacy rows. After that one-time copy, the API and legacy app operate on their own tables. On Render, the frontend is served at `/product-desk/` by the same service as the API.

## Local setup

1. Keep database credentials and token secrets in the ignored backend `.env`. Set `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD`, and `DB_NAME` to the Aiven connection values. Do not commit `.env`.
2. Set `JWT_SECRET` and `REFRESH_TOKEN_KEY` to different, random values, at least 32 characters each. Generate them locally with:

   ```powershell
   php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
   ```

3. Apply pending schema migrations from PowerShell. Migrations remain disabled in normal web requests:

   ```powershell
   $env:MIGRATIONS_ENABLED = 'true'
   php lava migration run
   Remove-Item Env:MIGRATIONS_ENABLED
   ```

   The migrations add `created_at`, limit the legacy product name to 100 characters, create the separate API tables with a one-time copy of existing records, and set the existing `kenne` account as the only administrator in both user tables. Migration 004 refuses to shorten the column if existing product names exceed that length; migration 006 stops if it cannot find exactly one `kenne` account in each table.
4. Set `FRONTEND_URL=http://localhost:5173` in the backend `.env`.
5. Start the backend in one terminal:

   ```powershell
   php lava serve
   ```

6. Start the React app in another terminal:

   ```powershell
   cd frontend
   Copy-Item .env.example .env
   npm ci
   npm run dev
   ```

   Open `http://localhost:5173`. Sign in with the existing active `kenne` account for administrator access. Other accounts can sign in and view products but cannot add, edit, or delete them. New registrations are regular, read-only accounts.

## API

All endpoints are under `/api`. Login and token refresh are public; product operations require `Authorization: Bearer <access_token>`.

| Method | Endpoint | Authentication | Purpose |
|---|---|---|---|
| POST | `/api/auth/register` | No | Create an API-only account in `api_users` (username, email, password); assigns only the regular read-only `user` role |
| POST | `/api/auth/login` | No | Login with `identifier` (username or email) and `password` |
| POST | `/api/auth/refresh` | Refresh token | Rotate tokens |
| POST | `/api/auth/logout` | Access token | Revoke the supplied refresh token and log out |
| GET | `/api/health` | No | Render health check; verifies database connectivity |
| GET | `/api/products` | Yes | List products |
| GET | `/api/products/{id}` | Yes | Read one product |
| POST | `/api/products` | Yes | Create a product |
| PUT/PATCH | `/api/products/{id}` | Yes | Replace or partially update product fields |
| DELETE | `/api/products/{id}` | Yes | Delete a product |

Product JSON fields are `product_name`, `description`, `price`, and `quantity`. Authenticated users can view products; only the administrator has the write and delete scopes required to create, update, or delete them. API products are stored in `api_products`; legacy Product Management continues using `products`. API accounts are stored in `api_users`; the legacy login continues using `users`. Both application surfaces enforce the account's active status and server-side role. The API returns JSON through LavaLust's `Api` library and validates input before using prepared SQL statements.

## Render

The root `render.yaml` describes one Docker service for the LavaLust API and React frontend. The existing Render service uses `public/Dockerfile`; each build compiles the React frontend into `public/product-desk/`, and the backend continues to handle `/api`. Connect the repository to Render as a Blueprint if creating a new service. Provide the Aiven values for `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD`, and `DB_NAME`. Render generates separate `JWT_SECRET` and `REFRESH_TOKEN_KEY` values. The API pre-deploy command applies pending migrations using a one-command `MIGRATIONS_ENABLED=true` override; public web requests keep migrations disabled.

For the existing same-origin Render service:

- Set API service `FRONTEND_URL` to its exact HTTPS origin (no path or trailing slash) if it is configured.
- The frontend uses the relative `/api` URL in production, so it and the API share the same Render hostname.

Check `https://your-api.onrender.com/api/health` before logging in. Open `https://your-api.onrender.com/product-desk/` for the frontend. Keep the Aiven database credentials and both JWT secrets only in Render's environment settings.

## Submission URLs

The assignment asks for separate backend and frontend GitHub repositories, but this project is deployed as one monorepo and one Render service to use the existing Render URL. The frontend source remains isolated in `frontend/`. Do not put credentials, tokens, or screenshots containing secrets in either repository.
