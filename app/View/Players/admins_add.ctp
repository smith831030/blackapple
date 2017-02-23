
<!--<NOTICE>-->
<div class="col-md-8 col-md-offset-2">
    <?php echo $this->Form->create('BaPlayer', array('class'=>'form-horizontal')); ?>
        <fieldset>
            <legend><?php echo __('Add Player'); ?></legend>

            <?php
            echo $this->Form->input('BaPlayer.p_status', array(
                'options' => array(1=>'In Squad', 2=>'On Loan', 3=>'Transfer', 4=>'Youth'),
                'empty' => '(choose one)',
                'class'=>'form-control',
                'required'
            ));
            ?>
            <?php echo $this->Form->input('BaPlayer.p_name', array('type'=>'text', 'class'=>'form-control', 'required'));?>
            <?php echo $this->Form->input('BaPlayer.p_position', array(
                        'options'=>array('GK'=>'Goal Keeper',
                                        'DF'=>'Defender',
                                        'MF'=>'Midfielder',
                                        'ST'=>'Striker',
                                        'MG'=>'Manager'),
                        'class'=>'form-control',
                        'required'
            ));?>
            <?php echo $this->Form->input('BaPlayer.p_backnumber', array('type'=>'number', 'class'=>'form-control'));?>
            <?php echo $this->Form->input('BaPlayer.p_nationality', array('type'=>'text', 'class'=>'form-control'));?>

            <button type="submit" id="btn_submit" class="btn btn-primary">Add</button>
        </fieldset>
    <?php echo $this->Form->end(); ?>
    <?php //echo $this->element('sql_dump'); ?>
</div>
<div class="clearfix"></div>
<!--</NOTICE>-->
