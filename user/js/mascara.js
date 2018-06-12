function maskit(w,e,m,r,a){

    /*
    w: Referência ao elemento. Normalmente é this.
    e: Evento usado para cancelar o Backspace.
    m: Máscara a ser aplicada.
    r: Aplicar a mascara da direita para a esquerda. Opcional [true|false] - Dafault : false.
    a: Objeto com informações para aplicar após a máscara. Use você precisar aplicar alguma informação sempre no começo ou no fim do valor independente da máscara, como exemplo "R$" em campos do tipo monetário. Sintaxe: {[pre:'value'[,pos:'value']]}.
    Exemplo: onkeyup="maskit(this,event,'###.###.###-##')" mascara de cpf
    */


    // Cancela se o evento for Backspace

    if (!e) var e = window.event

    if (e.keyCode) code = e.keyCode;

    else if (e.which) code = e.which;



    // Variáveis da função

    var txt = (!r) ? w.value.replace(/[^\d]+/gi,'') : w.value.replace(/[^\d]+/gi,'').reverse();

    var mask = (!r) ? m : m.reverse();

    var pre = (a ) ? a.pre : "";

    var pos = (a ) ? a.pos : "";

    var ret = "";



    if(code == 9 || code == 8 || txt.length == mask.replace(/[^#]+/g,'').length) return false;



    // Loop na máscara para aplicar os caracteres

    for(var x=0,y=0, z=mask.length;x<z && y<txt.length;){

    if(mask.charAt(x)!='#'){

    ret += mask.charAt(x); x++;

    } else{

    ret += txt.charAt(y); y++; x++;

    }

    }



    // Retorno da função

    ret = (!r) ? ret : ret.reverse()

    w.value = pre+ret+pos;

    }



    // Novo método para o objeto 'String'

    String.prototype.reverse = function(){

    return this.split('').reverse().join('');

};
