---
layout: page
title: Projetos
permalink: /projects/
---
<script>
function getGithubRepos() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var ul = document.createElement('ul');
        document.getElementById('repos').appendChild(ul);
        var obj = JSON.parse(this.responseText);
        obj.forEach(renderProductList);
    
        function renderProductList(element) {
            var li = document.createElement('li');
            ul.appendChild(li);
            li.innerHTML = li.innerHTML + "<a href="+element.html_url+">" + element.name + "</a>";
        }
    }
  };
  xhttp.open("GET", "https://api.github.com/orgs/phpba/repos?type=public", true);
  xhttp.send();
}
window.onload = getGithubRepos();
</script>

No nosso repostório temos alguns projetos em andamento e precisamos de ajuda para continuar com eles. Não importa o seu nível de conhecimento, ele será de suma importância para nós.
Se você está iniciando, participe, aprenda e aumente seu portifólio. Se você já é senior, ajude os iniciantes e melhore nosso código e nossa arquitetura.

Esse é o [link](https://github.com/phpba)  para a página dos nossos projetos.

E está listado abaixo todos os projetos em andamento:

<div id="repos"></div>

Lembrando que damos preferência para projetos de código aberto e a mundaça de licença dos projetos deverá ser discutida na comunidade.