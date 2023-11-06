//função para abrir o menu quando a tela for diminuida
const ul=  document.querySelector('ul')
function ShowNavBar(){
    if(ul.classList.contains('open')){
      ul.classList.remove('open')

    }else{
      ul.classList.add('open')
    }

}
//fechar o menu quando for rolada a tela a
const scrooPos = window.pageXOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
  window.addEventListener('scroll', function(){

    let newScrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;

    if(newScrollPos > scrooPos){
      ul.classList.remove('open');
    }
  })