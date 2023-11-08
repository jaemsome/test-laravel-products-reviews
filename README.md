<p>
To generate dummy data for products and reviews (5 records each at a time)<br/>
<code>php artisan db:seed</code>
</p>

<p>
Database Location: <code>{app_root}/database</code><br/>
Production DB: <code>{app_root}/database/database.sqlite</code><br/>
Testing DB: <code>{app_root}/database/testing.sqlite</code>
</p>

<br/>

<h1>Endpoints:</h1>
<p>
<b>Retrieve a list of Products with their reviews.</b><br/>
<i>Returns an empty array if nothing is found.</i><br/>
<code>GET: https://{domain}/api/products</code>
</p>

<p>
<b>Retrieve a single Product with its reviews.</b><br/>
<i>Returns null to product field and error message.</i><br/>
<code>GET: https://{domain}/api/products/{id}</code>
</p>

<p>
<b>Create a new Product.</b><br/>
Required: name, price | Optional: description<br/>
Name: String | Price: Limits to 2 decimal places<br/>
<i>When it fails, returns null to product field and error message.</i><br/>
<code>POST: https://{domain}/api/products</code>
</p>

<p>
<b>Create a new Product Review.</b><br/>
Required: name, rating | Optional: comment<br/>
Name: String | Rating: Between 1 to 5<br/>
<i>When it fails, returns null to review field and error message.</i><br/>
<code>POST: https://{domain}/api/products/{id}/reviews</code>
</p>

<p>
<b>Update a Product.</b><br/>
Required: name, price | Optional: description<br/>
Name: String | Price: Limits to 2 decimal places<br/>
<i>When it fails, returns null to product field and error message.</i><br/>
<code>PUT: https://{domain}/api/products/{id}</code>
</p>

<p>
<b>Delete a Product.</b><br/>
<i>Returns a product object on successful, null and error message if fails / no records found.</i><br/>
<code>DELETE: https://{domain}/api/products/{id}</code>
</p>

<br/>

<h1>Tests:</h1>
<p>
To do a test to all API endpoints<br/>
<code>php artisan test --filter=ProductControllerTest</code>
</p>

<p>
To do a test relates to creating a product<br/>
<code>php artisan test --group=create_product</code>
</p>

<p>
To do a test relates to updating a product<br/>
<code>php artisan test --group=updating_product</code>
</p>

<p>
To do a test relates to deleting a product<br/>
<code>php artisan test --group=delete_product</code>
</p>

<p>
To do a test relates to creating a product review<br/>
<code>php artisan test --group=create_product_review</code>
</p>
