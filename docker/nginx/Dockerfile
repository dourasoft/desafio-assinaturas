FROM nginx:alpine

RUN apk update && apk add bash

RUN rm /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/conf.d

# Exponha a porta 80, que é a porta padrão do nginx
EXPOSE 80

# Comando para iniciar o nginx quando um contêiner baseado nesta imagem for executado
CMD ["nginx", "-g", "daemon off;"]