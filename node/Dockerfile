FROM node:20-alpine

EXPOSE 5173

WORKDIR app/

COPY --link --chmod=755 ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint

USER node

ENTRYPOINT ["docker-entrypoint"]

CMD ["yarn", "dev", "--host"]