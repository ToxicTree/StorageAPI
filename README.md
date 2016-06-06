# StorageAPI
Simple Storage API using sqlite, built upon [Lumen](https://github.com/laravel/lumen)

##### API Endpoints
<table>
<tr><th>HTTP Method</th>    <th>URI</th>            <th>Action</th></tr>
<tr><td>GET/HEAD</td>       <td>api/</td>           <td>Fetches all tables</td></tr>
<tr><td>GET/HEAD</td>       <td>api/table</td>      <td>Fetches specified table</td></tr>
<tr><td>POST</td>           <td>api/</td>           <td>Creates a new table (need field 'name')</td></tr>
<tr><td><s>PUT/PATCH</s></td>      <td><s>api/table</s></td>      <td><s>Updates an existing table</s></td></tr>
<tr><td>DELETE</td>         <td>api/table</td>      <td>Deletes specified table</td></tr>
</table>

##### Install
      git clone https://github.com/ToxicTree/StorageAPI.git
      cd StorageAPI
      composer install
      cp .env.example .env

##### Running development server
      cd public
      php -S localhost:8000
