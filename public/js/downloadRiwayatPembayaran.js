function downloadRiwayat(token) {
    fetch("http://127.0.0.1:8000/api/riwayat-pembayaran/export", {
        method: "GET",
        headers: {
            Authorization: `Bearer ${token}`,
            Accept: "text/csv",
        },
    })
        .then((response) => {
            if (!response.ok) {
                alert("Gagal mendownload CSV");
                return;
            }
            return response.blob();
        })
        .then((blob) => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "riwayat_pembayaran.csv";
            a.click();
        });
}

//jan lup pake ini di blade yang ada riwayat pembayarannya
/* 
<button onclick="downloadRiwayat('{{ $token }}')">
    Download CSV
</button>

<script src="{{ asset('js/download.js') }}"></script>

*/
