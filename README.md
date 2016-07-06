# StorageAPI
Simple Storage API using sqlite, built upon [Lumen](https://github.com/laravel/lumen)

##### API Endpoints
<table>
<tr><th>HTTP Method</th> <th>URI</th>          <th>Action</th></tr>

<tr><td>GET</td>         <td>api/</td>         <td>Fetches all tables</td></tr>
<tr><td>GET</td>         <td>api/table</td>    <td>Fetches all posts in specified table</td></tr>
<tr><td>GET</td>         <td>api/table/id</td> <td>Fetches post with specified id from table</td></tr>

<tr><td>POST</td>        <td>api/</td>         <td>Creates a new table</td></tr>
<tr><td>PUT</td>         <td>api/table</td>    <td>Updates an existing table</td></tr>
<tr><td>DELETE</td>      <td>api/table</td>    <td>Deletes specified table</td></tr>

<tr><td>POST</td>        <td>api/table</td>    <td>Creates a new post in table</td></tr>
<tr><td>PUT</td>         <td>api/table/id</td> <td>Updates a existing post in table</td></tr>
<tr><td>DELETE</td>      <td>api/table/id</td> <td>Deletes specified id from table</td></tr>
</table>

##### Install
      git clone https://github.com/ToxicTree/StorageAPI.git
      cd StorageAPI
      composer install
      cp .env.example .env

##### Running development server
      cd public
      php -S localhost:8000
