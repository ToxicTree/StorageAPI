# StorageAPI
Simple and dynamic Storage API using sqlite, built upon [Lumen](https://github.com/laravel/lumen)

Editor can be found here: [StorageAPI_Editor](https://github.com/ToxicTree/StorageAPI_Editor)

##### API Endpoints
<table>
<tr><th>HTTP Method</th> <th>URI</th>          <th>Action</th></tr>

<tr><td>GET</td>         <td>/</td>         <td>Fetches all tables</td></tr>
<tr><td>GET</td>         <td>/table</td>    <td>Fetches all posts in specified table</td></tr>
<tr><td>GET</td>         <td>/table/id</td> <td>Fetches post with specified id from table</td></tr>

<tr><td>POST</td>        <td>/</td>         <td>Creates a new table</td></tr>
<tr><td>PUT</td>         <td>/table</td>    <td>Updates an existing table</td></tr>
<tr><td>DELETE</td>      <td>/table</td>    <td>Deletes specified table</td></tr>

<tr><td>POST</td>        <td>/table</td>    <td>Creates a new post in table</td></tr>
<tr><td>PUT</td>         <td>/table/id</td> <td>Updates a existing post in table</td></tr>
<tr><td>DELETE</td>      <td>/table/id</td> <td>Deletes specified id from table</td></tr>
</table>

##### Install
```bash
git clone https://github.com/ToxicTree/StorageAPI.git
cd StorageAPI
composer install
```

##### Running development server
```bash
cd public
php -S localhost:8000
```
