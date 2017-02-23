
    <table class="table">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('p_name', 'Name'); ?></th>
                <th><?php echo $this->Paginator->sort('p_position', 'Position'); ?></th>
                <th><?php echo $this->Paginator->sort('p_backnumber', 'Back Number'); ?></th>
                <th><?php echo $this->Paginator->sort('p_nationality', 'Nationality'); ?></th>
                <th><?php echo $this->Paginator->sort('p_status', 'Status'); ?></th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($players as $player): ?>
            <tr>
                <td><?php echo $player['BaPlayer']['p_name'];?></td>
                <td><?php echo $player['BaPlayer']['p_position']?></td>
                <td><?php echo $player['BaPlayer']['p_backnumber']?></td>
                <td><?php echo $player['BaPlayer']['p_nationality']?></td>
                <td>
                    <?php
                    switch($player['BaPlayer']['p_status']){
                        case 1:
                            $status='In Squad';
                            $class='success';
                            break;
                        case 2:
                            $status='On Loan';
                            $class='primary';
                            break;
                        case 3:
                            $status='Transfer';
                            $class='danger';
                            break;
                        case 4:
                            $status='Youth';
                            $class='warning';
                            break;
                    }
                    ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-<?=$class;?> btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $status;?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="/Admins/Players/status/<?php echo $player['BaPlayer']['id'];?>/1">In Squad</a></li>
                            <li><a href="/Admins/Players/status/<?php echo $player['BaPlayer']['id'];?>/2">On Loan</a></li>
                            <li><a href="/Admins/Players/status/<?php echo $player['BaPlayer']['id'];?>/3">Transfer</a></li>
                            <li><a href="/Admins/Players/status/<?php echo $player['BaPlayer']['id'];?>/4">Youth</a></li>
                        </ul>
                    </div>
                </td>
                <td><a href="/Admins/Players/modify/<?php echo $player['BaPlayer']['id'];?>" class="btn btn-default btn-xs">Modify</a></td>
            </tr>
            <?php endforeach; ?>
            <?php unset($post); ?>
        </tbody>
    </table>

    <!-- <paging> -->
    <div class="text-center">
        <ul class="pagination">
            <?php echo $this->Paginator->numbers(array('tag'=>'li', 'currentTag'=>'a', 'currentClass'=>'active', 'separator'=>''));?>
        </ul>
    </div>
    <!-- </paging> -->

    <div class="text-right">
        <?php echo $this->Html->link('Add', '/Admins/Players/add', array('class'=>'btn btn-default')); ?>
    </div>
    <?php //echo $this->element('sql_dump'); ?>
</div>
