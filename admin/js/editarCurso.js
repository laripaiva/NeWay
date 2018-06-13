$('.dropdown-trigger').dropdown();

$(document).ready(function(){
	$('.sidenav').sidenav();
});

   // Tabs => módulos
   $(document).ready(function(){
   	$('.tabs').tabs();
   });

     $(document).ready(function(){
    $('.modal').modal();
  })
     $('#textarea1').val('Conteúdo textual');
  M.textareaAutoResize($('#textarea1'));