<?php
require 'inc/functions.php';

$page = "reports";
$pageTitle = "Reports | Time Tracker";
$filter = 'all';

if(!empty($_GET['filter'])){
    $filter = explode(':', filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING));
}

include 'inc/header.php';
?>
<div class="col-container page-container">
    <div class="col col-70-md col-60-lg col-center">
        <div class="col-container">
            <h1 class='actions-header'>Reports</h1>
            <form class='form-container form-report' action='reports.php' method='get'>
                <label for='filter'>Filter:</label>
                <select id='filter' name='filter'>
                    <option value=''>Select sth</option>
                    <optgroup label="Project">
                    <?php 
                        foreach(get_project_list() as $item){
                            echo '<option value="project:' .$item['project_id'] .'">';
                            echo $item['title'] . "</option>";
                        }
                    ?>
                    </optgroup>
                    <optgroup label="Category">
                        <option value="category:Billable">Billable</option>
                        <option value="category:Charity">Charity</option>
                        <option value="category:Personal">Personal</option>
                    </optgroup>
                    <optgroup label="Date">
                        <option value="date:<?php 
                        echo date('d/m/y',strtotime('-2 Monday'));
                        echo ":";
                        echo date('d/m/y', strtotime('-1 Sunday'));
                        ?>"> <?php echo date('d/m/y', strtotime('-1 Monday')); ?></option> 
                        <!-- //Last Week -->
                        <option value="date:<?php 
                        echo date('d/m/y',strtotime('-1 Monday')); // -1 week
                        echo ":";
                        echo date('d/m/y');
                        ?>"><?php echo date('d/m/y'); ?></option>
                        <option value="date:<?php 
                        echo date('d/m/y',strtotime('first day of last month'));
                        echo ":";
                        echo date('d/m/y', strtotime('last day of last month'));
                        ?>"><?php echo date('d/m/y', strtotime('last day of last month'))?></option>
                        <option value="date:<?php 
                        echo date('d/m/y',strtotime('first day of  next month'));
                        echo ":";
                        echo date('d/m/y');
                        ?>"><?php echo date('d/m/y',strtotime('first day of  next month'))?></option>
                    </optgroup>
                </select>
                <input class="button" type="submit" value="kuku" />
            </form>
        </div>
        <div class="section page">
            <div class="wrapper">
                <table>
                    <?php               
                    $total = $project_id = $project_total = 0;
                    $tasks = get_task_list($filter);

                    foreach ($tasks as $i){
                        if($project_id !== $i['project_id']){
                            $project_id = $i['project_id'];
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>" .$i['project'] . "</th>";
                            echo "<th>Date</th>";
                            echo "<th>Time</th>";
                            echo "</tr>";
                            echo "</thead>";
                        }

                        $project_total += $i['time'];
                        $total += $i['time'];
                        echo "<tr>\n";
                        echo "<td>" . $i['title'] ."</td>\n";
                        echo "<td>" . $i['date'] ."</td>\n";
                        echo "<td>" . $i['time'] ."</td>\n";
                        echo "<tr>\n";

                        if(next($tasks)['project_id'] != $i['project_id']){
                            echo "<tr>";
                            echo "<th class='project-total-label' colspan='2'>Project Total</th>";
                            echo "<th class='project-total-number'>$project_total</th>";
                            echo "</tr>";
                            $project_total = 0;
                        }
                    }
                    ?>
                    <tr>
                        <th class='grand-total-label' colspan='2'>Grand Total</th>
                        <th class='grand-total-number'><?php echo $total; ?></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>

