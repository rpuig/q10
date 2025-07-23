


<div class="container" style="height:100vh ">
            <div class="row h-100">

 




                <div class="col">
                 <h1>Tennis Games results</h1>

                    <table id="dataTable1">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Tournament Name</th>
                                <th>Winner Name</th>
                                <th>Runner-Up Name</th>
                                <th>Avg Elo Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tennis[0] as $row) : ?>
                                <tr>
                             
                                    <td><?= $row['date'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['winner_name'] ?></td>
                                    <td><?= $row['runnerUp_name'] ?></td>
                                    <td><?= $row['titleAvgEloRating'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    </div>
                
<div class="col">
                
                    <h1>Players in male ATP </h1>
                    <table id="dataTable2">
                        <thead>
                            <tr>
                                <th>rank</th>
                                <th>name</th>
                                <th>Winner country_name</th>
                                <th>active</th>
                                <th>dob</th><th>totalPoints</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tennis[1] as $row) : ?>
                                <tr>
                                    <td><?= $row['rank'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['country_name'] ?></td>
                                    <td><?= $row['active'] ?></td>
                                    <td><?= $row['dob'] ?></td>
                                    <td><?= $row['totalPoints'] ?></td>





                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
            </div> 

                      
             


    </div>

     </div>

 <script>
    document.addEventListener("DOMContentLoaded", function() {
        function setupSortableTable(tableId) {
            const dataTable = document.getElementById(tableId);
            if (!dataTable) {
                console.error("Table with ID", tableId, "not found.");
                return;
            }
            const headers = dataTable.querySelectorAll("thead th");

            console.log("Setting up table with ID:", tableId);

            headers.forEach(header => {
                header.addEventListener("click", () => {
                    console.log("Clicked on header:", header.textContent);

                    const column = header.cellIndex;
                    const order = header.dataset.order === "asc" ? "desc" : "asc";

                    Array.from(dataTable.querySelectorAll("tbody tr"))
                        .sort((a, b) => {
                            const aValue = a.cells[column].textContent.trim();
                            const bValue = b.cells[column].textContent.trim();

                            return order === "asc" ?
                                aValue.localeCompare(bValue, undefined, { numeric: true }) :
                                bValue.localeCompare(aValue, undefined, { numeric: true });
                        })
                        .forEach(row => dataTable.querySelector("tbody").appendChild(row));

                    headers.forEach(header => header.dataset.order = "");
                    header.dataset.order = order;
                });
            });
        }

        // Call setupSortableTable function for each table with its unique ID
        setupSortableTable("dataTable1");
        setupSortableTable("dataTable2");
        // Add more tables as needed
    });
</script>