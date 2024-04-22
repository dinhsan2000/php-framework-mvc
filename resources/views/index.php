<h1>
    Hello, World!
</h1>
<thead>
<th>id</th>
<th>name</th>
<th>email</th>
</thead>
<?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= $user['name'] ?></td>
        <td><?= $user['email'] ?></td>
    </tr>
<?php endforeach; ?>