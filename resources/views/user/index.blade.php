<thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->updated_at }}</td>
            <td>
                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('user.destroy', $user->id) }}" class="btn btn-danger">Delete</a>
            </td>
        </tr>
    @endforeach
</tbody>