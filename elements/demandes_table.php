<div class="table-wrapper">
    <table class="alt">
        <thead>
            <tr>
                <?php
                foreach ($columns as $value) {
                    if ($value != 'hotel_id' && $value != 'user_id' && $value != 'demande_type')
                        echo '<th>' . $value . '</th>';
                }
                ?>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($Hotels_demandes->num_rows > 0)
                while ($row = mysqli_fetch_assoc($Hotels_demandes)) {
                    echo '<tr>';
                    foreach ($columns as $value) {
                        if ($value != 'hotel_id' && $value != 'user_id' && $value != 'demande_type')
                            echo '<td>' . $row[$value] . '</td>';
                    }
                    echo '<td><ul class="actions small">
                <li><a href="?demande_id=' . $row['Demande ID'] . '&demande_type=' . $row["demande_type"] . '&id=' . $row[$columns[0]] . '&decision=1" style="background-color:Green;" class="button small icon solid fa-check"></a></li>
                <li><a href="?demande_id=' . $row['Demande ID'] . '&demande_type=' . $row["demande_type"] . '&id=' . $row[$columns[0]] . '&decision=0" style="background-color:red;" onclick="return confirm(\'Are you sure?\')"  class="button small icon solid fa-times"></a></li>
                
            </ul></td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</div>