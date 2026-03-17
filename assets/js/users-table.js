document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const tableBody = document.getElementById("usersTableBody");

  if (searchInput && tableBody) {
    searchInput.addEventListener("keyup", function () {
      const filter = searchInput.value.toLowerCase();
      const rows = tableBody.getElementsByTagName("tr");

      for (let i = 0; i < rows.length; i++) {
        if (rows[i].getElementsByTagName("td").length === 1) continue;

        const nameCol = rows[i].getElementsByTagName("td")[1];
        const roomCol = rows[i].getElementsByTagName("td")[2];
        const extCol = rows[i].getElementsByTagName("td")[3];

        if (nameCol && roomCol && extCol) {
          const nameText = nameCol.textContent || nameCol.innerText;
          const roomText = roomCol.textContent || roomCol.innerText;
          const extText = extCol.textContent || extCol.innerText;

          if (
            nameText.toLowerCase().indexOf(filter) > -1 ||
            roomText.toLowerCase().indexOf(filter) > -1 ||
            extText.toLowerCase().indexOf(filter) > -1
          ) {
            rows[i].style.display = "";
          } else {
            rows[i].style.display = "none";
          }
        }
      }
    });
  }
});
