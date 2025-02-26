<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Display Antrian</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }

        .main-card {
            font-size: 3rem;
            padding: 30px;
        }

        .sub-card {
            font-size: 1.5rem;
            padding: 20px;
        }
    </style>
    <script>
        window.Laravel = {
            audioPath: "{{ asset('audio') }}"
        };
    </script>
</head>

<body>
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold">Display Antrian</h1>
            <p class="lead text-muted">Nomor antrian yang terpanggil per loket</p>
        </div>
        <!-- Container untuk kartu-kartu -->
        <div id="cardsContainer"></div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /********************
         * Announcement Queue
         ********************/
        let announcementQueue = [];
        let isPlaying = false;

        function enqueueAnnouncement(announcement) {
            announcementQueue.push(announcement);
            processQueue();
        }

        function processQueue() {
            if (isPlaying || announcementQueue.length === 0) return;
            isPlaying = true;
            let announcement = announcementQueue.shift();
            playAnnouncement(announcement.nomor, announcement.loket, () => {
                isPlaying = false;
                processQueue();
            });
        }

        /********************
         * Audio Playback
         ********************/
        // Modified playAnnouncement with callback
        function playAnnouncement(nomor, loket, callback) {
            let audioFiles = [];
            let baseAudioPath = window.Laravel.audioPath;

            // Mulai dengan file pembuka
            audioFiles.push(`${baseAudioPath}/in.wav`);
            audioFiles.push(`${baseAudioPath}/nomor-urut.MP3`);

            // Konversi nomor ke string
            let nomorStr = nomor.toString();
            let intNum = parseInt(nomorStr);

            if (!isNaN(intNum)) {
                if (intNum < 10) {
                    audioFiles.push(`${baseAudioPath}/${intNum}.MP3`);
                } else if (intNum === 10) {
                    audioFiles.push(`${baseAudioPath}/sepuluh.MP3`);
                } else if (intNum === 11) {
                    audioFiles.push(`${baseAudioPath}/sebelas.MP3`);
                } else if (intNum < 20) {
                    let unit = intNum % 10;
                    audioFiles.push(`${baseAudioPath}/${unit}.MP3`);
                    audioFiles.push(`${baseAudioPath}/belas.MP3`);
                } else if (intNum < 100) {
                    let tens = Math.floor(intNum / 10);
                    let units = intNum % 10;
                    audioFiles.push(`${baseAudioPath}/${tens}.MP3`);
                    audioFiles.push(`${baseAudioPath}/puluh.MP3`);
                    if (units > 0) {
                        audioFiles.push(`${baseAudioPath}/${units}.MP3`);
                    }
                } else {
                    // Untuk angka 100 ke atas, mainkan tiap digit
                    Array.from(nomorStr).forEach(function(digit) {
                        audioFiles.push(`${baseAudioPath}/${digit}.MP3`);
                    });
                }
            }

            // Tambahkan pengumuman loket
            audioFiles.push(`${baseAudioPath}/loket.MP3`);
            let loketStr = loket.toString();
            let loketNum = loketStr.replace(/[^\d]/g, '');
            if (loketNum) {
                let intLoket = parseInt(loketNum);
                if (intLoket < 10) {
                    audioFiles.push(`${baseAudioPath}/${intLoket}.MP3`);
                } else {
                    Array.from(loketNum).forEach(function(digit) {
                        audioFiles.push(`${baseAudioPath}/${digit}.MP3`);
                    });
                }
            }

            // Akhiri dengan out.wav
            audioFiles.push(`${baseAudioPath}/out.wav`);

            playSequentially(audioFiles, 0, callback);
        }

        // playSequentially menerima callback saat selesai
        function playSequentially(files, index, callback) {
            if (index >= files.length) {
                callback();
                return;
            }
            let audio = new Audio(files[index]);
            audio.play().catch(error => console.error('Error playing audio:', error));
            audio.onended = function() {
                playSequentially(files, index + 1, callback);
            };
        }

        /********************
         * Display Update & Polling
         ********************/
        // Menyimpan data antrian terakhir (untuk perbandingan)
        let lastAnnouncementData = {
            id: null,
            updated_at: null
        };

        function updateDisplay() {
            fetch("{{ route('api.antrian-terkini') }}")
                .then(response => response.json())
                .then(data => {
                    // Kelompokkan data berdasarkan loket (ambil antrian terbaru per loket)
                    let groups = {};
                    data.forEach(item => {
                        let loketId = item.loket.id;
                        if (!groups[loketId] || new Date(item.updated_at) > new Date(groups[loketId]
                                .updated_at)) {
                            groups[loketId] = item;
                        }
                    });
                    let loketItems = Object.values(groups);
                    // Urutkan berdasarkan updated_at secara menurun
                    loketItems.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));

                    let mainCard = '';
                    let subCards = '';

                    if (loketItems.length > 0) {
                        // Main card: loket dengan antrian terbaru
                        let main = loketItems[0];
                        mainCard = `
                          <div class="card text-white bg-primary mb-4 main-card">
                              <div class="card-body text-center">
                                  <h1 class="display-1 fw-bold">${main.nomor}</h1>
                                  <p class="small"> ${main.loket.nama}</p>
                                  <p class="card-text lead">Diperbarui: ${new Date(main.updated_at).toLocaleTimeString()}</p>
                              </div>
                          </div>
                      `;
                        // Sub cards: untuk loket lainnya
                        if (loketItems.length > 1) {
                            subCards = `<div class="row">`;
                            for (let i = 1; i < loketItems.length; i++) {
                                let item = loketItems[i];
                                subCards += `
                                  <div class="col-md-4 mb-3">
                                      <div class="card text-white bg-secondary sub-card">
                                          <div class="card-body text-center">
                                              <h3 class="card-title">${item.nomor}</h3>
                                              <p class="card-text">Loket: ${item.loket.nama}</p>
                                              <p class="small">${new Date(item.updated_at).toLocaleTimeString()}</p>
                                          </div>
                                      </div>
                                  </div>
                              `;
                            }
                            subCards += `</div>`;
                        }
                    } else {
                        mainCard = `<div class="alert alert-info">Belum ada nomor yang terpanggil.</div>`;
                    }

                    document.getElementById('cardsContainer').innerHTML = mainCard + subCards;

                    // Enqueue announcement jika ada perubahan global (data[0])
                    if (data.length > 0) {
                        let latest = data[0];
                        if (latest.id !== lastAnnouncementData.id || latest.updated_at !== lastAnnouncementData
                            .updated_at) {
                            lastAnnouncementData = {
                                id: latest.id,
                                updated_at: latest.updated_at
                            };
                            enqueueAnnouncement({
                                nomor: latest.nomor,
                                loket: latest.loket.nama
                            });
                        }
                    }
                })
                .catch(error => console.error("Error fetching antrian data:", error));
        }

        // Mulai polling setiap 5 detik
        setInterval(updateDisplay, 5000);
        updateDisplay();
    </script>
</body>

</html>
