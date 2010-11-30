<div class="clearfix">
<div id="searchbox">
<?php

echo $this->Form->create('Issue', array('action' => 'search','type' => 'get'));
echo $this->Form->text('keywords');
echo $this->Form->end('Search');

?>
</div>
</div>
