
<head>
    <title>Pelanggan</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<div class="m-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="text-header mb-5">
                <h4 class="text-center">
                    Table Pelanggan
                </h4>
            </div>
            
            <div class="rounded bg-white p-4">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Foto</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelanggan as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>{{ $item->no_hp }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>
                                    <img src="{{ asset('uploads/pelanggan_images') }}/{{ $item->foto }}" style="width: 50px; height: 50px; object-fit: cover">
                                </td>
                                <td>{{ $item->user->email }}</td>

                            </tr>
                        @empty
                            <td colspan="6" class="text-center">Record Not Found</td>    
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>