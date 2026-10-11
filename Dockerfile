FROM node:22-alpine
WORKDIR /app
COPY package.json ./
RUN npm install --omit=dev || true
COPY . .
ENV DB_PATH=/app/data/crm.db PORT=3000
VOLUME /app/data
EXPOSE 3000
CMD ["npm", "start"]
