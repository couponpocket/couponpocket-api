FROM node:12.16 AS cs-node

# make the '/var/www/html' folder the current working directory
WORKDIR /var/www/html

# copy both 'package.json' and 'package-lock.json' (if available)
COPY ./html/package*.json ./

# install project dependencies
RUN npm install

## Start Development Setup
FROM cs-node AS cs-node-dev

ENV NODE_ENV development

CMD ["npm", "run", "watch"]

## Start Production Setup
FROM cs-node AS cs-node-prod

ENV NODE_ENV production
