<h3>To generate dummy data for products and reviews (5 records each at a time)</h3>
<code>php artisan db:seed<code>

<h3>Database Location {app_root}/database</h3>
<h3>Production DB: {app_root}/database/database.sqlite</h3>
<h3>Testing DB: {app_root}/database/testing.sqlite</h3>

<h1>Endpoints:<h1>
<h3>Retrieve a list of Products with their reviews.</h3>
<h3>Returns an empty array if nothing is found.</h3>
<code>GET: https://{domain}/api/products<code>

<h3>Retrieve a single Product with its reviews.</h3>
<h3>Returns null to product field and error message.</h3>
<code>GET: https://{domain}/api/products/{id}<code>

<h3>Create a new Product.</h3>
<h3>Required: name, price | Optional: description</h3>
<h3>Name: String | Price: Limits to 2 decimal places</h3>
<h3>When it fails, returns null to product field and error message.</h3>
<code>POST: https://{domain}/api/products<code>

<h3>Create a new Product Review.</h3>
<h3>Required: name, rating | Optional: comment</h3>
<h3>Name: String | Rating: Between 1 to 5</h3>
<h3>When it fails, returns null to review field and error message.</h3>
<code>POST: https://{domain}/api/products/{id}/reviews<code>

<h3>Update a Product.</h3>
<h3>Required: name, price | Optional: description</h3>
<h3>Name: String | Price: Limits to 2 decimal places</h3>
<h3>When it fails, returns null to product field and error message.</h3>
<code>PUT: https://{domain}/api/products/{id}<code>

<h3>Delete a Product.</h3>
<h3>Returns a product object on successful, null and error message if fails / no records found.</h3>
<code>DELETE: https://{domain}/api/products/{id}<code>

<h1>Tests:<h1>
<h3>To do a test to all API endpoints</h3>
<code>php artisan test --filter=ProductControllerTest<code>

<h3>To do a test relates to creating a product</h3>
<code>php artisan test --group=create_product<code>

<h3>To do a test relates to updating a product</h3>
<code>php artisan test --group=updating_product<code>

<h3>To do a test relates to deleting a product</h3>
<code>php artisan test --group=delete_product<code>

<h3>To do a test relates to creating a product review</h3>
<code>php artisan test --group=create_product_review<code>
