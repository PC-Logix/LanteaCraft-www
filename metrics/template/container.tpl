<div class="content-container <?=$this->cssClasses?>" style="<?=$this->css?>">
	<fieldset><legend><?php
		if ($this->title_icon)
			echo "<img src='resource/image/" . $this->title_icon . "' />";
		echo $this->title;
		?></legend> 
		<?php
			// Treat object as renderable usually; others should be
			// string literals (if not, ohwell).
			if (gettype($this->content) == "object") 
				$this->content->render();
			else
				echo $this->content;
		?>
	</fieldset> 
</div>