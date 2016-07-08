<div class="form content">
    <div id="voto">
        <div id="voto_izq">
            <?= $this->Form->create($feedback) ?>
            <fieldset>
                <legend><?= __('Valora tu experiencia:') ?></legend>
                <?php
                    echo $this->Form->input('ispositive', ['label' => '¿La experiencia en general ha sido positiva?:', 'type' => 'select', 'options' => ['0' => 'No', '1'=>'Sí']]);
                    echo $this->Form->input('description', ['label' => 'Describe tu experiencia:', 'type' => 'textarea']);
                 ?>
            </fieldset>
        </div>
        <div id="voto_der">
            <fieldset>
            <legend><?= __('Por favor, valora estos aspectos del 1 al 5:') ?></legend>
               	<br>
    		    <?php 
    		    	foreach ($answers as $answer): 
    	        		echo $this->Form->input('values[]', ['label' => $answer->question->name, 'options' => $posiblevalues, 'default' => 3]);
    	        	endforeach;
    	        ?>
            </fieldset>
        </div>
        <div id="voto_abj">
            <?= $this->Form->button(__('Guardar')) ?>
            <?= $this->Html->link('Cancelar', '/', ['class' => 'button']) ?>
        </div>
    </div>
</div>