@if ($componentType == "ADD")
    @include('livewire.reservasi.createReservasi')
@endif

@if ($componentType == "EDIT")
    @include('livewire.reservasi.editReservasi')
@endif

@if ($componentType == "LIST")

@section('title')
    Reservasi
@endsection


<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="text-header mb-5">
                <h4 class="text-primary">
                    Table Reservasi
                    @if (Auth::user()->level != 'pelanggan')
                        <button wire:click="addForm" class="btn btn-primary float-end">Add <i class='bx bx-plus'></i></button>
                        <a href="{{ route('reservasi.print') }}" class="btn btn-outline-info float-end mx-2" target="_blank">EXPORT  <i class='bx bx-download'></i></a>
                        {{-- <input class="form-control float-end mx-2" type="text" style="width: 300px" wire:model="search" placeholder="Status..."> --}}
                        <select style="width: 300px" class="form-control float-end mx-2" wire:model="search">
                            <option value="">pilih status</option>
                            <option value="pesan">pesan</option>
                            <option value="selesai">selesai</option>
                            <option value="dibayar">dibayar</option>
                        </select>
                        <div>
                            <input type="date" style="width: 100px" class="form-control float-end mx-2" placeholder="Tanggal Awal" wire:model="startDate">
                            <input type="date" style="width: 100px" class="form-control float-end mx-2" placeholder="Tanggal Akhir" wire:model="endDate">
                        </div>
                    @endif
                </h4>
            </div>
            
            <div class="shadow-sm rounded p-4 bg-white">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr style="vertical-align: top">
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Daftar Paket</th>
                            <th>Tgl Reservasi</th>
                            <th>Harga</th>
                            <th>Peserta</th>
                            <th>Diskon</th>
                            <th>Nilai Diskon</th>
                            <th>Total Bayar</th>
                            <th>Bukti Tf</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($reservasi as $key => $item)
                            <tr>
                                @if (Auth::user()->level == 'pelanggan')
                                    <td>{{ $key+1 }}</td>
                                @elseif (Auth::user()->level != 'pelanggan')
                                    <td>{{ $reservasi->firstItem() + $key }}</td>
                                @endif
                                <td>{{ $item->pelanggan->nama_lengkap }}</td>
                                <td>{{ $item->daftar_paket->nama_paket }}</td>
                                <td>{{ date('d-M-y',strtotime($item->tgl_reservasi_wisata)) }}</td>
                                <td>Rp.{{ number_format($item->harga) }}</td>
                                <td>{{ $item->jumlah_peserta }}</td>
                                <td>{{ number_format($item->diskon) }}%</td>
                                <td>Rp.{{ number_format($item->nilai_diskon) }}</td>
                                <td>Rp.{{ number_format($item->total_bayar) }}</td>
                                <td>
                                    <img src="{{ asset('uploads/reservasi_images') }}/{{ $item->file_bukti_tf }}" style="width: 50px; height: 50px; object-fit: cover">
                                </td>
                                <td>
                                    <p class=" 
                                    align-middle
                                    @if ($item->status_reservasi_wisata == 'dibayar')
                                        text-blue
                                    @elseif ($item->status_reservasi_wisata == 'selesai')
                                        text-green
                                    @elseif ($item->status_reservasi_wisata == 'pesan')
                                        text-red
                                    @endif
                                ">{{ $item->status_reservasi_wisata }}</p>
                                </td>

                                <td class="text-center">
                                    <button wire:click="editForm({{ $item->id }})" class="btn btn-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(255, 255, 255);transform: ;msFilter:;"><path d="m18.988 2.012 3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287-3-3L8 13z"></path><path d="M19 19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z"></path></svg>
                                    </button>

                                    @if (Auth::user()->level != 'pelanggan')
                                        <button wire:click="deleteReservasi({{ $item->id }})" class="btn btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(255, 255, 255);transform: ;msFilter:;"><path d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm10.618-3L15 2H9L7.382 4H3v2h18V4z"></path></svg>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <td colspan="12" class="text-center">Record Not Found</td>    
                        @endforelse
                    </tbody>
                </table>
                @if (Auth::user()->level != 'pelanggan')
                    {{ $reservasi->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<script>
    window.addEventListener('showSuccess', event => {
        defaultToast({title: event.detail.title})
    })

    window.addEventListener('showDeleteAlert', event => {
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            livewire.emit('removeReservasi')
            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
            )
        }
        })
    })
</script>