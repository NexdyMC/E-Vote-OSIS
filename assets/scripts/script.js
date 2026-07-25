async function selectKardidat(id_kardidat, name) {
    // 1. Show confirmation dialog using SweetAlert2
    const result = await Swal.fire({
        title: `Pilih ${name}?`,
        text: "Pilihan tidak dapat diubah setelah dikonfirmasi.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Pilih!",
        cancelButtonText: "Batal"
    });

    // 2. Proceed only if the user clicked "Ya, Pilih!"
    if (result.isConfirmed) {
        try {
            const response = await fetch("vote.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    id_kardidat: id_kardidat,
                    button: true
                })
            });

            if (!response.ok) {
                throw new Error("Network response was not ok");
            }

            const data = await response.json();
            await Swal.fire({
                title: "Berhasil!",
                text: `Vote untuk ${name} berhasil disimpan.`,
                icon: "success"
            });

            setTimeout(() => {
                location.href = "index.php";
            }, 500);

        } catch (error) {
            console.error(error);
            Swal.fire({
                title: "Gagal!",
                text: "Terjadi kesalahan saat memproses voting.",
                icon: "error"
            });
        }
    }
}