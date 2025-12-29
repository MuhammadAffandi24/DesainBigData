<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>STOKIFY - Dashboard</title>
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
* { box-sizing: border-box; }

body {
  margin: 0;
  font-family: 'Poppins', sans-serif;
  background: #E4D8C8;
}

/* ================= NAVBAR FIX ================= */
.navbar {
  height: 80px; /* lebih ramping & rapi */
  background: linear-gradient(90deg, #2b1d0f, #3a2814);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 60px;
}

/* LOGO AREA */
.navbar .logo {
  display: flex;
  align-items: center;
}

.logo-link {
  display: flex;
  align-items: center;
  gap: 14px;
  text-decoration: none;
}

.logo-icon {
  width: 26px;
  height: 26px;
  object-fit: contain;
}

.logo-link h3 {
  font-size: 20px;
  font-weight: 600;
  margin: 0;
  color: #E1D4C2;
  letter-spacing: 1px;
}

/* MENU */
.navbar nav ul {
  list-style: none;
  display: flex;
  align-items: center;
  gap: 28px;
  margin: 0;
  padding: 0;
}

.navbar nav ul li a {
  color: #E1D4C2;
  font-size: 16px;
  font-weight: 500;
  text-decoration: none;
  position: relative;
}

/* hover underline halus */
.navbar nav ul li a::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -6px;
  width: 0%;
  height: 2px;
  background: #AFA59A;
  transition: width .25s ease;
}

.navbar nav ul li a:hover::after {
  width: 100%;
}

/* ================= DASHBOARD ================= */
.wrapper { padding: 40px 120px; }

/* ================= TABS ================= */
.tabs {
  position: relative;
  display: grid;
  grid-template-columns: repeat(4,1fr);
  text-align: center;
  font-size: 22px;
}
.tab {
  cursor: pointer;
  padding: 10px;
}
.tab.active { font-weight: 600; }

.indicator {
  position: absolute;
  bottom: -6px;
  width: 25%;
  height: 6px;
  background: #AFA59A;
  border-radius: 10px;
  transition: transform .25s ease;
}

.divider {
  border-top: 1px solid #000;
  margin: 20px 0 30px;
}

/* ================= DATE PICKER ================= */
.picker {
  text-align: center;
  margin-bottom: 20px;
}
.picker input[type="date"] {
  appearance: none;
  background: #fff;
  border: 2px solid #6E473B;
  border-radius: 14px;
  padding: 8px 16px;
  font-family: 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 500;
  color: #291C0E;
  cursor: pointer;
  box-shadow: 0 3px 8px rgba(0,0,0,.15);
}
.picker input[type="date"]:hover { background: #f5efe7; }
.picker input[type="date"]:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(110,71,59,.3);
}

/* ================= SUMMARY ================= */
.summary {
  display: grid;
  grid-template-columns: repeat(3,1fr);
  text-align: center;
  margin-bottom: 30px;
}
.label { font-size: 24px; }
.value { font-size: 32px; font-weight: 700; }

/* ================= CARD ================= */
.card {
  background: #6E473B;
  border-radius: 50px;
  padding: 30px;
  margin-bottom: 40px;
}
.line-card { height: 350px; }

.lower {
  display: grid;
  grid-template-columns: 3fr 1fr;
  gap: 40px;
}
.bar-card, .pie-card {
  height: 350px;
  position: relative;
}

canvas { display: block; }
</style>
</head>

<body>

{{-- HEADER --}}
<header class="navbar">
  <div class="logo">
    <a class="logo-link">
      <img src="{{ asset('assets/menu.svg') }}" 
           alt="Menu" 
           class="logo-icon" 
           onclick="toggleSidebar()" 
           style="cursor: pointer;">
      <img src="{{ asset('assets/navbar&footer.svg') }}" 
           alt="Logo STOKIFY" 
           class="logo-icon">
      <h3>STOKIFY</h3>
    </a>
  </div>

  <nav>
    <ul>
      <li><a href="{{ url('/home') }}">Home</a></li>
      <li><a href="{{ url('/barang') }}">Manajemen</a></li>
      <li><a href="{{ url('/home') }}#riwayat-belanja">Belanja</a></li>
    </ul>
  </nav>

  <div class="logo">
    <a class="logo-link">
      <img src="{{ asset('assets/pp.svg') }}" 
           alt="PP" 
           class="logo-icon">
    </a>
  </div>
</header>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <div class="close-btn" onclick="toggleSidebar()">
    <i class="fas fa-times"></i>
  </div>

  <div class="logo">
    <a class="logo-link">
      <img src="{{ asset('assets/close.svg') }}" 
           alt="Close" 
           class="logo-icon" 
           onclick="toggleSidebar()">
    </a>
  </div>

  <ul class="sidebar-menu">
    <li><a href="#" class="active">Home</a></li>

    <li class="dropdown">
      <a href="#">Manajemen</a>
      <ul class="submenu">
        <li><a href="#">Manajemen Barang</a></li>
        <li><a href="#">Riwayat Belanja</a></li>
        <li><a href="#">Manajemen Tagihan</a></li>
        <ul class="submenu">
          <li><a href="#">Riwayat Pembayaran</a></li>
          <li><a href="#">Riwayat Tagihan</a></li>
        </ul>
      </ul>
    </li>

    <li><a href="#">Belanja</a></li>
    <li><a href="#">Pengaturan</a></li>
    <li><a href="#">Akun</a></li>

    <li>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
      </form>
    </li>
  </ul>
</aside>


<div class="wrapper">

  <!-- TABS -->
  <div class="tabs">
    <div class="indicator" id="indicator"></div>
    <div class="tab active" data-filter="harian">Harian</div>
    <div class="tab" data-filter="mingguan">Mingguan</div>
    <div class="tab" data-filter="bulanan">Bulanan</div>
    <div class="tab" data-filter="tahunan">Tahunan</div>
  </div>
  <div class="divider"></div>

  <!-- DATE -->
  <div class="picker">
    <input type="date" id="datePicker">
  </div>

  <!-- SUMMARY -->
  <div class="summary">
    <div>
      <div class="label">Pengeluaran Terendah</div>
      <div class="value" id="minVal">Rp.0,-</div>
    </div>
    <div>
      <div class="label">Pengeluaran Rata-Rata</div>
      <div class="value" id="avgVal">Rp.0,-</div>
    </div>
    <div>
      <div class="label">Pengeluaran Tertinggi</div>
      <div class="value" id="maxVal">Rp.0,-</div>
    </div>
  </div>

  <!-- LINE -->
  <div class="card line-card">
    <canvas id="lineChart"></canvas>
  </div>

  <!-- BAR + PIE -->
  <div class="lower">
    <div class="card bar-card"><canvas id="barChart"></canvas></div>
    <div class="card pie-card"><canvas id="pieChart"></canvas></div>
  </div>

</div>

<script>
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('active');
}
/* ================= GLOBAL CHART CONFIG ================= */
Chart.defaults.color = '#AFA59A';
Chart.defaults.font.family = 'Poppins';
Chart.defaults.font.size = 13;
Chart.defaults.animation.duration = 900;
Chart.defaults.animation.easing = 'easeInOutQuart';
Chart.defaults.interaction.mode = 'index';
Chart.defaults.interaction.intersect = false;

let lineChart, barChart, pieChart;
let currentFilter = 'harian';

const lineChartCanvas = document.getElementById('lineChart');
const barChartCanvas  = document.getElementById('barChart');
const pieChartCanvas  = document.getElementById('pieChart');
const datePicker      = document.getElementById('datePicker');

function rupiah(n){
  return 'Rp.' + Number(n||0).toLocaleString('id-ID') + ',-';
}

function loadChart(filter = currentFilter){
  const date = datePicker.value || new Date().toISOString().slice(0,10);
  datePicker.value = date;

  fetch(`/dashboard/data?filter=${filter}&date=${date}`)
    .then(res => res.json())
    .then(data => {

      const out = data.line.pengeluaran.map(Number);

      /* ===== SUMMARY ===== */
      if (out.length) {
        minVal.innerText = rupiah(Math.min(...out));
        maxVal.innerText = rupiah(Math.max(...out));
        avgVal.innerText = rupiah(out.reduce((a,b)=>a+b,0)/out.length);
      } else {
        minVal.innerText = avgVal.innerText = maxVal.innerText = 'Rp.0,-';
      }

      /* ===== LINE ===== */
      if (!lineChart) {
        lineChart = new Chart(lineChartCanvas,{
          type:'line',
          data:{
            labels:data.line.labels,
            datasets:[
  {
    label:'Pembayaran Barang',
    data:out,
    borderColor:'#E1D4C2',
    backgroundColor:'rgba(225,212,194,.35)',
    borderWidth:2,
    tension:.4,
    fill:true
  }
]

          },
          options:{ responsive:true, maintainAspectRatio:false }
        });
      } else {
        lineChart.data.labels = data.line.labels;
        lineChart.data.datasets[0].data = out;
        lineChart.update();
      }

      /* ===== BAR ===== */
      if (!barChart) {
        barChart = new Chart(barChartCanvas,{
          type:'bar',
          data:{
            labels:data.bar.map(b=>b.nama_barang),
            datasets:[{
              label:'Jumlah',
              data:data.bar.map(b=>b.jumlah_barang),
              backgroundColor:'#E1D4C2',
              borderRadius:8,
              barThickness:22
            }]
          },
          options:{
            indexAxis:'y',
            responsive:true,
            maintainAspectRatio:false
          }
        });
      } else {
        barChart.data.labels = data.bar.map(b=>b.nama_barang);
        barChart.data.datasets[0].data = data.bar.map(b=>b.jumlah_barang);
        barChart.update();
      }

      /* ===== PIE ===== */
      if (!pieChart) {
        pieChart = new Chart(pieChartCanvas,{
          type:'doughnut',
          data:{
            labels:data.pie.map(p=>p.kategori),
            datasets:[{
              data:data.pie.map(p=>p.total),
              backgroundColor:['#E1D4C2','#D96464','#BB9765'],
              borderWidth:3,
              borderColor:'#6E473B'
            }]
          },
          options:{
            cutout:'65%',
            responsive:true,
            maintainAspectRatio:false
          }
        });
      } else {
        pieChart.data.labels = data.pie.map(p=>p.kategori);
        pieChart.data.datasets[0].data = data.pie.map(p=>p.total);
        pieChart.update();
      }
    });
}

/* ===== TAB ===== */
document.querySelectorAll('.tab').forEach((tab,i)=>{
  tab.onclick = ()=>{
    document.querySelector('.tab.active').classList.remove('active');
    tab.classList.add('active');
    indicator.style.transform = `translateX(${i*100}%)`;
    currentFilter = tab.dataset.filter;
    loadChart(currentFilter);
  };
});

/* ===== DATE ===== */
datePicker.onchange = ()=> loadChart(currentFilter);

/* ===== INIT ===== */
datePicker.valueAsDate = new Date();
loadChart('harian');
</script>

</body>
</html>
