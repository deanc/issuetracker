<div class="clearfix">
<div id="searchbox">
<?php

echo $this->Form->create('Issue', array('action' => 'search','type' => 'get'));
echo $this->Form->text('keywords', array('value' => (!empty($this->params['url']['keywords']) ? $this->params['url']['keywords']: '')));
echo $this->Form->end('Search');

?>
</div>
</div>
