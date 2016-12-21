<table class="table table-hover">
    <thead>
    <tr>
        <th>Informations de votre compte</th>
        <td>Vos informations</td>
    </tr>
    </thead>
  <tbody>
    <tr>
      <th scope="row">Nom</th>
      <td><?php echo $data[0]['last_name']?></td>
    </tr>
    <tr>
      <th scope="row">Prenom</th>
      <td><?php echo $data[0]['first_name']?></td>
    </tr>
    <tr>
      <th scope="row">Pseudo</th>
        <td><?php echo $data[0]['pseudo']?></td>
    </tr>
    <tr>
        <th scope="row">Date d'anniversaire</th>
        <td><?php echo $data[0]['birthday']?></td>
    </tr>
    <tr>
        <th scope="row">Genre</th>
        <td><?php echo $data[0]['gender']?></td>
    </tr>
    <tr>
        <th scope="row">Ville</th>
        <td><?php echo $data[0]['city']?></td>
    </tr>
    <tr>
        <th scope="row">Departement</th>
        <td><?php echo $data[0]['department']?></td>
    </tr>
    <tr>
        <th scope="row">Region</th>
        <td><?php echo $data[0]['region']?></td>
    </tr>
    <tr>
        <th scope="row">Pays</th>
        <td><?php echo $data[0]['country']?></td>
    </tr>
    <tr>
        <th scope="row">Pseudo</th>
        <td><?php echo $data[0]['pseudo']?></td>
    </tr>
    <tr>
        <th scope="row">Email</th>
        <td><?php echo $data[0]['email']?></td>
    </tr>
  </tbody>
</table>