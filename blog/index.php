<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { margin: 0; display: flex; flex-direction: column; height: 100vh; background-color: #f8f9fa; }
        
        header { background: #2c3e50; color: white; padding: 15px 20px; text-align: left; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        header h2 { margin: 0; font-size: 1.2rem; }
        header h2 i { margin-right: 8px; }

        .container { 
            display: flex; 
            flex: 1; 
            overflow: hidden; 
            background-color: #f8f9fa; 
            align-items: flex-start; 
        }

        nav { 
            width: 250px; 
            background: #ffffff; 
            padding: 20px 10px; 
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin: 20px 10px 20px 20px; 
        }
        
        .menu-title { font-size: 0.8rem; color: #6c757d; font-weight: 700; margin-bottom: 12px; padding-left: 15px; text-transform: uppercase; letter-spacing: 0.5px; }
        nav button i { width: 20px; text-align: center; margin-right: 8px; }
        
        nav button { 
            display: block; width: 100%; padding: 12px 15px; margin-bottom: 8px; 
            cursor: pointer; text-align: left; border: none; background: none; 
            border-radius: 8px; color: #495057; transition: 0.3s; font-weight: 500;
        }
        nav button:hover { background-color: #e9ecef; color: #007bff; }
        nav button.active { background-color: #e7f1ff; color: #007bff; }

        main { 
            flex: 1; 
            padding: 30px; 
            background: #ffffff; 
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin: 20px 20px 20px 10px; 
            max-height: calc(100vh - 90px);
            overflow-y: auto;
        }

        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .section-header h3 { margin: 0; }
        .btn-tambah { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 500; }

        table { 
            width: 100%; 
            border-collapse: collapse;
        }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
        th { background-color: #f8f9fa; color: #495057; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; border-bottom: 2px solid #dee2e6; }

        .img-tabel-penulis { 
            width: 50px; height: 50px; border-radius: 5px; object-fit: cover; border: 1px solid #ddd;
        }

        .action-btns {
            display: flex;
            gap: 5px; 
            align-items: center;
        }

        .action-btns button { 
            padding: 8px 12px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            transition: 0.2s; 
            font-weight: 500;
            white-space: nowrap; 
        }
        .btn-edit { background: #0d1f7b; color: white; }
        .btn-edit:hover { background: #e0a800; }
        .btn-hapus { background: #dc3545; color: white; }
        .btn-hapus:hover { background: #e0a800; }

        .modal { display: none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.4); z-index: 1000; }
        .modal-content { background: white; margin: 5% auto; padding: 25px; width: 40%; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; }
    </style>
</head>
<body>
    <header>
        <h2><i class="fas fa-desktop"></i> Sistem Manajemen Blog (CMS)</h2>
    </header>
    <div class="container">
        <nav>
            <div class="menu-title">Menu Utama</div>
            <button id="btn-penulis" onclick="loadPenulis()"><i class="fas fa-users"></i> Kelola Penulis</button>
            <button id="btn-artikel" onclick="loadArtikel()"><i class="fas fa-file-alt"></i> Kelola Artikel</button>
            <button id="btn-kategori" onclick="loadKategori()"><i class="fas fa-list"></i> Kelola Kategori Artikel</button>
        </nav>
        
        <main>
            <div id="contentArea"></div>
        </main>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <h3 id="modalTitle" style="margin-top: 0;">Form</h3>
            <form id="mainForm" onsubmit="saveData(event)">
                <input type="hidden" id="formId" name="id">
                <input type="hidden" id="formType">
                <div id="formInputs"></div>
                <div style="margin-top: 20px; text-align: right;">
                    <button type="button" onclick="closeModal()" style="background:#6c757d; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">Batal</button>
                    <button type="submit" style="background:#007bff; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; margin-left:10px;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content" style="width: 30%; text-align: left;">
            <h3 style="margin-top: 0;">Konfirmasi Hapus</h3>
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <div style="margin-top: 25px; text-align: right;">
                <button type="button" onclick="closeDeleteModal()" style="background:#6c757d; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">Batal</button>
                <button type="button" onclick="executeHapus()" style="background:#dc3545; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; margin-left:10px;">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        function setActive(id) {
            document.querySelectorAll('nav button').forEach(btn => btn.classList.remove('active'));
            document.getElementById(id).classList.add('active');
        }

        async function loadPenulis() {
            setActive('btn-penulis');
            document.getElementById('contentArea').innerHTML = `
                <div class="section-header">
                    <h3>Data Penulis</h3>
                    <button class="btn-tambah" onclick="openModal('penulis')">+ Tambah Penulis</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 80px; text-align: center;">Foto</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tblPenulisBody">
                        <tr><td colspan="5" style="text-align:center; color:#666;">Memuat data penulis...</td></tr>
                    </tbody>
                </table>`;
            
            try {
                const res = await fetch('ambil_penulis.php');
                const data = await res.json();
                
                const tbody = document.getElementById('tblPenulisBody');
                tbody.innerHTML = ''; 
                
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:#999;">Belum ada data penulis terdaftar.</td></tr>';
                    return;
                }

                data.forEach(d => {
                    const passwordDisplay = d.password ? d.password.substring(0, 8) + '...' : '********';
                    tbody.innerHTML += `
                        <tr>
                            <td style="text-align: center;">
                                <img src="uploads_penulis/${d.foto || 'default.png'}" class="img-tabel-penulis" alt="Foto">
                            </td>
                            <td><strong>${d.nama_depan} ${d.nama_belakang}</strong></td>
                            <td style="color: #007bff;">@${d.user_name}</td>
                            <td style="color: #666; font-style: italic;">${passwordDisplay}</td>
                            <td class="action-btns">
                                <button class="btn-edit" onclick="editPenulis(${d.id})">Edit</button> 
                                <button class="btn-hapus" onclick="hapusData('hapus_penulis.php', ${d.id}, loadPenulis)">Hapus</button>
                            </td>
                        </tr>`;
                });
            } catch (error) {
                document.getElementById('tblPenulisBody').innerHTML = '<tr><td colspan="5" style="text-align:center; color:red;">Gagal memuat data. Periksa koneksi database Anda.</td></tr>';
            }
        }

        async function loadKategori() {
            setActive('btn-kategori');
            document.getElementById('contentArea').innerHTML = `
                <div class="section-header">
                    <h3>Kategori Artikel</h3>
                    <button class="btn-tambah" onclick="openModal('kategori')">+ Tambah Kategori</button>
                </div>
                <table>
                    <thead>
                        <tr><th>Nama Kategori</th><th>Keterangan</th><th style="width:150px;">Aksi</th></tr>
                    </thead>
                    <tbody id="tblKategori">
                        <tr><td colspan="3" style="text-align:center; color:#666;">Memuat data...</td></tr>
                    </tbody>
                </table>`;
            
            try {
                const res = await fetch('ambil_kategori.php');
                const data = await res.json();
                const tbl = document.getElementById('tblKategori');
                tbl.innerHTML = '';
                
                if (data.length === 0) {
                    tbl.innerHTML = '<tr><td colspan="3" style="text-align:center; color:#999;">Belum ada kategori.</td></tr>';
                } else {
                    data.forEach(d => {
                        tbl.innerHTML += `<tr>
                            <td>${d.nama_kategori}</td><td>${d.keterangan}</td>
                            <td class="action-btns"><button class="btn-edit" onclick="editKategori(${d.id})">Edit</button> <button class="btn-hapus" onclick="hapusData('hapus_kategori.php', ${d.id}, loadKategori)">Hapus</button></td>
                        </tr>`;
                    });
                }
            } catch (error) {
                document.getElementById('tblKategori').innerHTML = '<tr><td colspan="3" style="text-align:center; color:red;">Gagal memuat data.</td></tr>';
            }
        }

        async function loadArtikel() {
            setActive('btn-artikel');
            document.getElementById('contentArea').innerHTML = `
                <div class="section-header">
                    <h3>Data Artikel</h3>
                    <button class="btn-tambah" onclick="openModal('artikel')">+ Tulis Artikel Baru</button>
                </div>
                <table>
                    <thead>
                        <tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tanggal</th><th style="width:150px;">Aksi</th></tr>
                    </thead>
                    <tbody id="tblArtikel">
                        <tr><td colspan="6" style="text-align:center; color:#666;">Memuat data...</td></tr>
                    </tbody>
                </table>`;
            
            try {
                const res = await fetch('ambil_artikel.php');
                const data = await res.json();
                const tbl = document.getElementById('tblArtikel');
                tbl.innerHTML = '';
                
                if (data.length === 0) {
                    tbl.innerHTML = '<tr><td colspan="6" style="text-align:center; color:#999;">Belum ada artikel.</td></tr>';
                } else {
                    data.forEach(d => {
                        tbl.innerHTML += `<tr>
                            <td><img src="uploads_artikel/${d.gambar}" style="width:60px; height:60px; object-fit:cover; border-radius:5px;" alt="Gambar"></td>
                            <td><strong>${d.judul}</strong></td><td>${d.nama_kategori}</td><td>${d.nama_depan} ${d.nama_belakang}</td><td>${d.hari_tanggal}</td>
                            <td class="action-btns"><button class="btn-edit" onclick="editArtikel(${d.id})">Edit</button> <button class="btn-hapus" onclick="hapusData('hapus_artikel.php', ${d.id}, loadArtikel)">Hapus</button></td>
                        </tr>`;
                    });
                }
            } catch (error) {
                document.getElementById('tblArtikel').innerHTML = '<tr><td colspan="6" style="text-align:center; color:red;">Gagal memuat data.</td></tr>';
            }
        }

        async function openModal(type, id = null) {
            document.getElementById('myModal').style.display = 'block';
            document.getElementById('formType').value = type;
            document.getElementById('formId').value = id || '';
            const isEdit = id !== null;
            document.getElementById('modalTitle').innerText = (isEdit ? 'Ubah ' : 'Tambah ') + (type === 'penulis' ? 'Penulis' : type === 'artikel' ? 'Artikel' : 'Kategori');
            
            let inputs = '';
            if(type === 'kategori') {
                inputs = `
                    <div class="form-group"><label>Nama Kategori</label><input type="text" name="nama_kategori" id="i_nama" required></div>
                    <div class="form-group"><label>Keterangan</label><textarea name="keterangan" id="i_ket" rows="3"></textarea></div>`;
            } else if(type === 'penulis') {
                inputs = `
                    <div style="display:flex; gap:10px;">
                        <div class="form-group" style="flex:1;"><label>Nama Depan</label><input type="text" name="nama_depan" id="i_depan" required></div>
                        <div class="form-group" style="flex:1;"><label>Nama Belakang</label><input type="text" name="nama_belakang" id="i_belakang" required></div>
                    </div>
                    <div class="form-group"><label>Username</label><input type="text" name="user_name" id="i_user" required></div>
                    <div class="form-group"><label>Password ${isEdit ? '(Kosongkan jika tidak diubah)' : ''}</label><input type="password" name="password" id="i_pass" ${!isEdit ? 'required' : ''}></div>
                    <div class="form-group"><label>Foto Profil</label><input type="file" name="foto" accept="image/*"></div>`;
            } else if(type === 'artikel') {
                const resK = await fetch('ambil_kategori.php'); const kat = await resK.json();
                const resP = await fetch('ambil_penulis.php'); const pen = await resP.json();
                let optKat = kat.map(k => `<option value="${k.id}">${k.nama_kategori}</option>`).join('');
                let optPen = pen.map(p => `<option value="${p.id}">${p.nama_depan} ${p.nama_belakang}</option>`).join('');
                inputs = `
                    <div class="form-group"><label>Judul Artikel</label><input type="text" name="judul" id="i_judul" required></div>
                    <div style="display:flex; gap:10px;">
                        <div class="form-group" style="flex:1;"><label>Kategori</label><select name="id_kategori" id="i_kat">${optKat}</select></div>
                        <div class="form-group" style="flex:1;"><label>Penulis</label><select name="id_penulis" id="i_pen">${optPen}</select></div>
                    </div>
                    <div class="form-group"><label>Isi Konten</label><textarea name="isi" id="i_isi" rows="6" required></textarea></div>
                    <div class="form-group"><label>Gambar Unggulan</label><input type="file" name="gambar" accept="image/*" ${!isEdit ? 'required' : ''}></div>`;
            }
            document.getElementById('formInputs').innerHTML = inputs;

            if(isEdit) {
                const res = await fetch(`ambil_satu_${type}.php?id=${id}`);
                const data = await res.json();
                if(type === 'kategori') { document.getElementById('i_nama').value = data.nama_kategori; document.getElementById('i_ket').value = data.keterangan; }
                if(type === 'penulis') { document.getElementById('i_depan').value = data.nama_depan; document.getElementById('i_belakang').value = data.nama_belakang; document.getElementById('i_user').value = data.user_name; }
                if(type === 'artikel') { document.getElementById('i_judul').value = data.judul; document.getElementById('i_kat').value = data.id_kategori; document.getElementById('i_pen').value = data.id_penulis; document.getElementById('i_isi').value = data.isi; }
            }
        }

        function closeModal() { 
            document.getElementById('myModal').style.display = 'none'; 
            document.getElementById('mainForm').reset(); 
        }

        async function saveData(e) {
            e.preventDefault();
            const form = document.getElementById('mainForm');
            const formData = new FormData(form);
            const type = document.getElementById('formType').value;
            const id = document.getElementById('formId').value;
            const url = id ? `update_${type}.php` : `simpan_${type}.php`;

            try {
                const res = await fetch(url, { method: 'POST', body: formData });
                const result = await res.json();
                
                if(result.status === 'success') {
                    closeModal();
                    if(type === 'kategori') loadKategori();
                    if(type === 'penulis') loadPenulis();
                    if(type === 'artikel') loadArtikel();
                } else { 
                    alert(result.pesan || "Terjadi kesalahan pada database!"); 
                }
            } catch (error) {
                alert("Gagal memproses data. Cek error di console jaringan (Network).");
            }
        }

        let targetHapusUrl = '';
        let targetHapusId = null;
        let targetHapusCallback = null;

        function hapusData(url, id, callbackLoad) {
            targetHapusUrl = url;
            targetHapusId = id;
            targetHapusCallback = callbackLoad;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        async function executeHapus() {
            closeDeleteModal();
            const fd = new FormData(); 
            fd.append('id', targetHapusId);
            try {
                const res = await fetch(targetHapusUrl, { method: 'POST', body: fd });
                const result = await res.json();
                if(result.status === 'success') {
                    targetHapusCallback(); 
                } else {
                    alert(result.pesan);
                }
            } catch (error) {
                alert("Gagal menghapus data.");
            }
        }

        const editKategori = (id) => openModal('kategori', id);
        const editPenulis = (id) => openModal('penulis', id);
        const editArtikel = (id) => openModal('artikel', id);

        window.onload = loadPenulis;
    </script>
</body>
</html>