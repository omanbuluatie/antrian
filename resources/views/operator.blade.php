<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Panel Operator - Antrian</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
      body {
          background-color: #f4f7f9;
          padding: 20px;
      }
      .card {
          border-radius: 10px;
          box-shadow: 0 4px 10px rgba(0,0,0,0.1);
          margin-bottom: 20px;
      }
      #message .alert {
          margin-bottom: 20px;
      }
  </style>
</head>
<body>
  <div class="container">
    <!-- Header -->
    <header class="text-center mb-5">
      <h1 class="fw-bold">Panel Operator Antrian</h1>
      <p class="lead text-muted">Kelola antrian dengan mudah dan cepat</p>
    </header>

    <!-- Pesan -->
    <div id="message"></div>

    <!-- Baris Informasi Utama -->
    <div class="row">
      <!-- Nomor Terakhir Terpanggil -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Nomor Terakhir Terpanggil</h5>
          </div>
          <div class="card-body text-center" id="lastAntrian">
            @if ($lastAntrian)
              <h2 class="display-4">{{ $lastAntrian->nomor }}</h2>
              <p class="lead">Loket: {{ $lastAntrian->loket->nama }}</p>
            @else
              <p class="text-muted">Belum ada nomor yang dipanggil.</p>
            @endif
          </div>
        </div>
      </div>
      <!-- Kelola Antrian -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-secondary text-white">
            <h5 class="card-title mb-0">Kelola Antrian</h5>
          </div>
          <div class="card-body">
            <form id="formManageAntrian">
              @csrf
              <div class="mb-3">
                <label for="loket_id" class="form-label">Pilih Loket:</label>
                <select name="loket_id" id="loket_id" class="form-select" required>
                  @foreach ($lokets as $loket)
                    <option value="{{ $loket->id }}">{{ $loket->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="d-flex">
                <button type="button" id="btnCallNext" class="btn btn-primary me-2 flex-fill">Nomor Selanjutnya</button>
                <button type="button" id="btnCallAgain" class="btn btn-warning flex-fill">Panggil Ulang</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Daftar Antrian -->
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Daftar Antrian</h5>
      </div>
      <div class="card-body" style="max-height: 300px; overflow-y: auto;">
        <ul id="antrianList" class="list-group">
          @foreach ($antrians as $antrian)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>{{ $antrian->nomor }} - Status: {{ $antrian->status }}</span>
              @if ($antrian->loket)
                <span class="badge bg-info text-dark">Loket: {{ $antrian->loket->nama }}</span>
              @endif
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS dan dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

  <script>
      // Fungsi untuk memperbarui tampilan nomor terakhir dan daftar antrian
      function updatePanel() {
          fetch("{{ route('api.antrian-all') }}")
              .then(response => response.json())
              .then(data => {
                  // Update Nomor Terakhir
                  let lastAntrianDiv = document.getElementById('lastAntrian');
                  if (data.lastAntrian) {
                      lastAntrianDiv.innerHTML = "<h2 class='display-4'>" + data.lastAntrian.nomor +
                          "</h2><p class='lead'>Loket: " + data.lastAntrian.loket.nama + "</p>";
                  } else {
                      lastAntrianDiv.innerHTML = "<p class='text-muted'>Belum ada nomor yang dipanggil.</p>";
                  }
                  // Update Daftar Antrian
                  let antrianList = document.getElementById('antrianList');
                  antrianList.innerHTML = "";
                  data.antrians.forEach(function(antrian) {
                      let li = document.createElement('li');
                      li.className = "list-group-item d-flex justify-content-between align-items-center";
                      li.innerHTML = antrian.nomor + " - Status: " + antrian.status +
                          (antrian.loket ? " <span class='badge bg-info text-dark'>Loket: " + antrian.loket.nama + "</span>" : "");
                      antrianList.appendChild(li);
                  });
              })
              .catch(error => console.error("Error fetching antrian data:", error));
      }

      // Tangani klik tombol "Nomor Selanjutnya"
      document.getElementById('btnCallNext').addEventListener('click', function() {
          let loketId = document.getElementById('loket_id').value;
          let formData = new FormData();
          formData.append('loket_id', loketId);

          fetch("{{ route('operator.callNext') }}", {
              method: 'POST',
              body: formData,
              headers: {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                  'Accept': 'application/json'
              }
          })
          .then(response => response.json())
          .then(data => {
              document.getElementById('message').innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
              updatePanel();
          })
          .catch(error => {
              console.error('Error:', error);
              document.getElementById('message').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan.</div>';
          });
      });

      // Tangani klik tombol "Panggil Ulang"
      document.getElementById('btnCallAgain').addEventListener('click', function() {
          let loketId = document.getElementById('loket_id').value;
          let formData = new FormData();
          formData.append('loket_id', loketId);

          fetch("{{ route('operator.callAgain') }}", {
              method: 'POST',
              body: formData,
              headers: {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                  'Accept': 'application/json'
              }
          })
          .then(response => response.json())
          .then(data => {
              document.getElementById('message').innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
              updatePanel();
          })
          .catch(error => {
              console.error('Error:', error);
              document.getElementById('message').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan.</div>';
          });
      });

      // Perbarui panel secara periodik (opsional)
      setInterval(updatePanel, 5000);
  </script>
</body>
</html>
