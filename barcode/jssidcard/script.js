$(document).ready(function () {
    $('#myTable').DataTable();
});

// ฟังก์ชันการแก้ไข
$('.edit').on('click', function(e) {
    const tr = $(this).closest("tr"); // ใช้ jQuery เพื่อเข้าถึงแถวที่คลิก
    const full_name = tr.find("td").eq(0).text(); // ดึงชื่อเต็ม
    const identification = tr.find("td").eq(1).text(); // ดึงหมายเลขบัตรประจำตัวประชาชน


    // แยกชื่อเต็ม
    const nameParts = full_name.split(" ");
    const name_title = nameParts[0];
    const name = nameParts[1];
    const surname = nameParts.slice(2).join(" ");

    // กำหนดค่าที่ได้ให้กับฟิลด์ในฟอร์มแก้ไข
    $("#name_titleEdit").val(name_title);
    $("#nameEdit").val(name);
    $("#surnameEdit").val(surname);
    $("#identificationEdit").val(identification);

    $('#editModal').modal('toggle'); // เปิด modal แก้ไข
});

// ฟังก์ชันการลบ
Array.from(document.getElementsByClassName('delete')).forEach(element => {
    element.addEventListener("click", e => {
        const sno = e.target.id.substr(1); // ลบอักขระแรก เช่น d1 ให้ได้ค่าหมายเลขเฉพาะ
        if (confirm("Are you sure you want to delete this note?")) {
            window.location = `index1.php?delete=${sno}`; // ลบตามค่า sno
        }
    });
});
