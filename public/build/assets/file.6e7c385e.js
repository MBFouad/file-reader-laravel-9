file={formSubmit:function(){var e=document.getElementById("file-reader-form"),n="reader-div";e.addEventListener("submit",function(t){if(t.preventDefault(),!e.checkValidity())t.stopPropagation();else{const o=new FormData(e),i=file.generateFormURL(e.action,e.method,o),a=file.generateFormParameters(e.method,o);fetch(i,a).then(r=>r.json()).then(r=>{r.error==!0?file.showError(n,r.message):document.getElementById(n).innerHTML=r.html}).catch(r=>{file.showError(n,r)})}return!1})},generateFormParameters:function(e,n){const t={method:e,headers:{"Content-Type":"application/json"}};return(e=="post"||e=="put")&&(t.body=JSON.stringify(n)),t},generateFormURL:function(e,n,t){if(n=="get"){const o=new URL(e);return o.search=new URLSearchParams(t).toString(),o}return e},showError:function(e,n){const t=document.createElement("div"),o=document.createTextNode(n);t.appendChild(o),t.className="alert alert-danger",t.setAttribute("role","alert");const i=document.getElementById(e);i.innerHTML=t.outerHTML},ajaxPaginationLinks:function(){var e="reader-div",n=document.getElementById(e);n.onclick=function(t){let o=t.target;if(o.tagName=="A"&&o.classList.contains("ajax-pagination-link")){t.preventDefault();const i=o.getAttribute("href"),a=file.generateFormParameters("get",{});return fetch(i,a).then(r=>r.json()).then(r=>{r.error==!0?file.showError(e,r.message):document.getElementById(e).innerHTML=r.html}).catch(r=>{file.showError(e,r)}),!1}}},init:function(){file.formSubmit(),file.ajaxPaginationLinks()}};file.init();