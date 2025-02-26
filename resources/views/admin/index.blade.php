<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Panel Admin - Pengaturan Antrian</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f7f9;
      padding-top: 50px;
    }
    .card {
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
      <h1 class="text-center mb-4">Panel Admin - Pengaturan Antrian</h1>

      <!-- Pesan Sukses/Error -->
      @if(session('success'))
         <div class="alert alert-success">
             {{ session('success') }}
         </div>
      @endif
      @if(session('error'))
         <div class="alert alert-danger">
             {{ session('error') }}
         </div>
      @endif

      <div class="row">
         <!-- Reset Nomor Urut -->
         <div class="col-md-6">
             <div class="card mb-4">
                 <div class="card-header bg-danger text-white">
                     <h5 class="card-title mb-0">Reset Nomor Urut</h5>
                 </div>
                 <div class="card-body">
                     <p>Tekan tombol berikut untuk mereset nomor antrian ke 0.</p>
                     <form action="{{ route('admin.resetQueue') }}" method="POST">
                         @csrf
                         <button type="submit" class="btn btn-danger w-100">Reset Nomor Antrian</button>
                     </form>
                 </div>
             </div>
         </div>

         <!-- Update Jumlah Loket -->
         <div class="col-md-6">
             <div class="card mb-4">
                 <div class="card-header bg-info text-white">
                     <h5 class="card-title mb-0">Atur Jumlah Loket</h5>
                 </div>
                 <div class="card-body">
                     <p>Masukkan jumlah loket (1-10). Saat diperbarui, sistem akan mengupdate tabel loket dengan data loket baru (misalnya, jika diinput 4, maka akan dibuat Loket 1, 2, 3, dan 4).</p>
                     <form action="{{ route('admin.updateLoket') }}" method="POST">
                         @csrf
                         <div class="mb-3">
                             <label for="jumlah_loket" class="form-label">Jumlah Loket:</label>
                             <input type="number" id="jumlah_loket" name="jumlah_loket" class="form-control" min="1" max="10" value="{{ $currentLoketCount ?? 1 }}">
                         </div>
                         <button type="submit" class="btn btn-info w-100">Update Loket</button>
                     </form>
                 </div>
             </div>
         </div>
      </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
