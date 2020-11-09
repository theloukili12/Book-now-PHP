<div class="table-wrapper">
    <table class="alt">
        <thead>
            <tr>
                <?php
                foreach ($columns as $value) {
                    if ($value != 'rid')
                    echo '<th>' . $value . '</th>';
                }
                ?>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($reservations as $r) {
                echo '<tr>';
                foreach ($columns as $value) {
                    if ($value != 'rid')
                    echo '<td>' . ($r[$value] == "" ? "Non spécifié" : $r[$value]) . '</td>';
                }
                echo '<td><ul class="actions small">
                <li><a titre="Consulter la reservation" data-rid="'.$r["rid"].'" class="button small select-reservation"><i class="fas fa-info"></i></a></li>                
            </ul></td>';
            }
            
            ?>
        </tbody>
    </table>
</div>