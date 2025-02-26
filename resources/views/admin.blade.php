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
  <div class="container">
    <!-- Header -->
    <header class="text-center mb-5">
      <h1 class="fw-bold">Panel Admin - Pengaturan Antrian</h1>
      <p class="lead text-muted">Reset nomor urut dan atur jumlah loket</p>
    </header>

    <!-- Area pesan (opsional, bisa diupdate dengan JS) -->
    <div id="message"></div>

    <div class="row">
      <!-- Reset Nomor Urut -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-danger text-white">
            <h5 class="card-title mb-0">Reset Nomor Urut</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Klik tombol di bawah untuk mereset nomor antrian ke 0.</p>
            <form id="formResetQueue" action="{{ route('admin.resetQueue') }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-danger w-100">Reset Nomor Urut</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Atur Jumlah Loket -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Atur Jumlah Loket</h5>
          </div>
          <div class="card-body">
            <p class="card-text">
              Pilih jumlah loket (maksimal 10). Misalnya, jika Anda memilih 4, maka sistem akan mengupdate tabel loket menjadi loket 1, 2, 3, dan 4.
            </p>
            <form id="formUpdateLoket" action="{{ route('admin.updateLoket') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="jumlah_loket" class="form-label">Jumlah Loket:</label>
                <input type="number" class="form-control" id="jumlah_loket" name="jumlah_loket" min="1" max="10" value="{{ $currentLoketCount ?? 1 }}">
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
  <script>
    // Jika diinginkan, Anda dapat menambahkan JavaScript untuk menangani form submission secara AJAX,
    // kemudian menampilkan pesan sukses atau error di dalam elemen #message.
    // Contoh (opsional):
    /*
    document.getElementById('formResetQueue').addEventListener('submit', function(e) {
      e.preventDefault();
      let form = e.target;
      let formData = new FormData(form);
      fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        document.getElementById('message').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
      })
      .catch(error => {
        console.error('Error:', error);
        document.getElementById('message').innerHTML = `<div class="alert alert-danger">Terjadi kesalahan.</div>`;
      });
    });
    */
  </script>
</body>
</html>
