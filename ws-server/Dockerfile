FROM node:20-alpine
WORKDIR /usr/src/app
COPY package.json .
RUN npm install --omit=dev --production || npm install --production
COPY server.js .
EXPOSE 8082
CMD ["node", "server.js"]
