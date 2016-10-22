<div>
  <h2>Category</h2>

  <h3>Add</h3>
  <?php
  echo $this->Form->create('BaPostCategory', array('class'=>'form-group'));
  echo $this->Form->input('category_title');
  echo $this->Form->submit('ADD', array('class'=>'btn btn-default'));
  echo $this->Form->end();
  ?>

  <h3>List</h3>
  <table class="table">
    <thead>
      <tr>
        <th>Category Name</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php
      if(sizeof($categories)>0):
        foreach($categories as $cate):
      ?>
      <form action="/Admins/Category/modify" method="post">
        <tr>
          <td>
            <input type="hidden" name="id" value="<?= $cate['BaPostCategory']['id'];?>">
            <input type="text" name="category_title" value="<?= $cate['BaPostCategory']['category_title'];?>">
            <input type="number" name="category_order" value="<?= $cate['BaPostCategory']['category_order'];?>">
          </td>
          <td>
            <button type="submit" class="btn btn-xs btn-default">Modify</button>
            <button type="button" class="btn btn-xs btn-default" onclick="cate_delete(<?= $cate['BaPostCategory']['id'];?>);">Delete</button>
          </td>
        </tr>
      </form>
      <?php
        endforeach;
      endif;
      ?>
    </tbody>
  </table>
</div>

<script>
  function cate_delete(id){
    if(confirm('Are you sure you want to delete this category?')){
      location.href='/Admins/Category/delete/'+id;
    }else{
      return false;
    }
  }
</script>
