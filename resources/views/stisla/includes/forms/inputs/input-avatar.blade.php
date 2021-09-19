@include('stisla.includes.forms.inputs.input', ['id'=>'avatar', 'type'=>'file', 'accept'=>'image/*',
'label'=>__('Avatar'),
'required'=>$required??true,
'icon'=>'fas fa-camera-retro'])
