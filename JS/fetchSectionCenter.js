async function fetchNoticia(){

    //Requisições feita para a API
    const response = await fetch('https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=381abe6077e9485f8f47231d32919b18');
    const responseScience = await fetch('https://newsapi.org/v2/top-headlines?country=us&category=science&apiKey=381abe6077e9485f8f47231d32919b18');
    const responsebusiness = await fetch('https://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=381abe6077e9485f8f47231d32919b18');

    DataNews = [];
    DataScience = [];
    DataBusiness = [];

    //verificação para saber se a requisição retornou tudo dentro da conformidade
    if(response.status >= 200 && response.status < 300){

      //O código a baixo tranformar a resposta da Api em um JSON
      const myJson = await response.json();
      const myJsonScience = await responseScience.json();
      const myJsonBusiness = await responsebusiness.json();
      
      DataNews = myJson;
      DataScience = myJsonScience;
      DataBusiness = myJsonBusiness;

      //as funções a baixo recebem O data como parâmetro
      exibirNewsTec(DataNews)
      mostrarNewsScience(DataScience)
      MostrarBusiness(DataBusiness)

    //caso ocorra um error na requisão 
    }else{
      console.log(response.status, response.statusText)
    }
}


let count = 0;
function exibirNewsTec(DataNews){

  //fiz uma ForEach dentro Data, acessando o article para perrorer todos os elementos que eu quero renderizar na tela 
  DataNews.articles.forEach(articles => {

    //Essa verificação faz que só crie 8 cardsNewsTec
    if(count < 8 ){

    const contentSectionCenterText = document.querySelector('.content__section__center__text');

    // Crie o elemento div com a classe "card"
    const card = document.createElement('div');
    card.className = 'card';
    card.style.width = '18rem';

    // Criado a tag de imagem
    const img = document.createElement('img');
    const imgUrl =  articles.urlToImage

    //verificação para saber se a imagem da API está retornando null, caso contrário, terá uma imagem default
    if(imgUrl){
      img.src = imgUrl;
    }else{
      img.src = 'IMAGENS/default.jpg'
    }
    img.className = 'card-img-top';

    // Criado a primeira div com a classe "card-body"
    const cardBody1 = document.createElement('div');
    cardBody1.className = 'card-body';

    // Criado o título do card
    const h5 = document.createElement('h5');
    h5.className = 'card-title';
    h5.textContent = articles.title;

    // Criado o parágrafo de texto do card
    const p = document.createElement('p');
    p.className = 'card-text';
    p.textContent = articles.description;

    // Criado a segunda div com a classe "card-body"
    const cardBody2 = document.createElement('div');
    cardBody2.className = 'container-card-body';

    // Criado o link do card
    const a = document.createElement('a');
    a.href = articles.url;
    a.className = 'card-link';
    a.textContent = 'Full News';

    // Anexe os elementos em cascata
    card.appendChild(img);
    card.appendChild(cardBody1);
    cardBody1.appendChild(h5);
    cardBody1.appendChild(p);
    card.appendChild(cardBody2);
    cardBody2.appendChild(a);

    //Selecionando o elemento com  contentSectionCenterText e adicione o novo elemento
    contentSectionCenterText.appendChild(card);

  }

  count++

  });
  
}

let count1 = 0;
function mostrarNewsScience (DataScience){
  
    //fiz uma ForEach dentro Data, acessando o article para perrorer todos os elementos que eu quero renderizar na tela 
  DataScience.articles.forEach(Element =>{

  //Essa verificação faz que só crie 8 cardsNewScience
    if ( count1 < 2){

    // Criado o elemento div com a classe "carousel-item"
    const carouselItem = document.createElement('div');
    carouselItem.className = 'carousel-item';

    // Criado a tag de imagem
    const img = document.createElement('img');
    img.className = 'd-block w-100';
    const imgUrl =  Element.urlToImage

    //verificação para saber se a imagem da API está retornando null, caso contrário, terá uma imagem default
    if(imgUrl){
      img.src = imgUrl;
    }else{
      img.src = 'IMAGENS/default.jpg'
    }

    // Criado a div com a classe "carousel-caption"
    const captionDiv = document.createElement('div');
    captionDiv.className = 'carousel-caption d-none d-md-block';

    // Criado o título 
    const h5 = document.createElement('h5');
    h5.textContent = Element.title;

    // Criado o parágrafo 
    const p = document.createElement('p');
    p.textContent = Element.description;

    // Anexe os elementos em cascata
    captionDiv.appendChild(h5);
    captionDiv.appendChild(p);
    carouselItem.appendChild(img);
    carouselItem.appendChild(captionDiv);

    //Selecionando o elemento com a classe "carousel-inner" e adicione o novo elemento
    const carouselInner = document.querySelector('.container-noticia-principal .container__content .content__right .carousel-inner');
    carouselInner.appendChild(carouselItem);

    }

  count1++
  })
}

let count2 = 0
function MostrarBusiness(DataBusiness){
  DataBusiness.articles.forEach(Element=>{

    if(count2 < 3){

  // criado o elemnto div com a classe "container__content__left"
    const containerContentLeft = document.createElement('div');
    containerContentLeft.className = 'container__content__left';

    // Criado o elemento div com a classe "contet__img__left"
    const contentImgLeft = document.createElement('div');
    contentImgLeft.className = 'contet__img__left';

    // Criado a tag de imagem
    const img = document.createElement('img');
    const imgUrl =  Element.urlToImage
    img.width = '160';
    img.height = '100';

    //verificação para saber se a imagem da API está retornando null, caso contrário, terá uma imagem default
    if(imgUrl){
      img.src = imgUrl;
    }else{
      img.src = 'IMAGENS/default.jpg'
    }

    //criada a div contentTextLeft
    const contentTextLeft = document.createElement('div');
    contentTextLeft.className = 'content__text__left';

    //criada a h6
    const h6 = document.createElement('h6');
    h6.textContent = Element.title;

    // Anexe os elementos em cascata
    contentImgLeft.appendChild(img);
    contentTextLeft.appendChild(h6);
    containerContentLeft.appendChild(contentImgLeft);
    containerContentLeft.appendChild(contentTextLeft);

// Selecionando o elemento com a classe "contentLeft" e adicione o novo elemento
    const contentLeft = document.querySelector('.content__left');
    contentLeft.appendChild(containerContentLeft);

    }

    count2++

  })

}

//Chamando a função para rodar tudo 
fetchNoticia()