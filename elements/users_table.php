<div class="table-wrapper">
    <table class="alt">
        <thead>
            <tr>
                <?php
                foreach ($columns as $value) {
                    
                    echo '<th>' . $value . '</th>';
                }
                ?>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($users as $r) {
                echo '<tr>';
                foreach ($columns as $value) {
                    
                    echo '<td>' . ($r[$value] == "" ? "Non spécifié" : $r[$value]) . '</td>';
                }
                echo '<td><ul class="actions small">
                <li><a data-uid="'.$r["ID"].'" class="button small delete-user"><i class="fas fa-user-minus"></i></a></li>                
            </ul></td>';
            }
            
            ?>
        </tbody>
    </table>
</div>