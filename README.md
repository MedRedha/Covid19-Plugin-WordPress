<h1 align="center">CoronApp</h1>

<p align="center">
	<a href="https://wuud.net">
		<img width="160" height="169" src="https://github.com/TeamWuuD/WuuD-Website/blob/master/favicon.ico?raw=true" alt="wuud">
	<img width="160" height="160" src="https://i.ya-webdesign.com/images/virus-transparent-animated-gif.gif" alt="coronapp">
	</a>
</p>
<p align="center">
	<a href="https://wuud.net">
		<img alt="Docker Automated build" src="https://img.shields.io/docker/automated/medredha/coronapp?color=brown&label=Build">
		<img alt="Docker Cloud Build Status" src="https://img.shields.io/docker/cloud/build/medredha/coronapp?color=yellow&label=Docker%20Build&logo=Redha">
	</a>
	<a href="https://wuud.net">
		<img alt="NPM" src="https://img.shields.io/npm/l/react?color=black">
		<img alt="GitHub package.json version" src="https://img.shields.io/github/package-json/v/MedRedha/CoronApp?color=red&label=Version">
		<img alt="GitHub package.json dependency version" src="https://img.shields.io/github/package-json/dependency-version/MedRedha/CoronApp/react">
		<img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/MedRedha/CoronApp?color=purple">
		<img alt="Website" src="https://img.shields.io/website?down_color=red&down_message=maintenance&style=flat-square&up_message=online&url=https%3A%2F%2Fwuud.net"> <img alt="GitHub stars" src="https://img.shields.io/github/stars/TeamWuuD/WuuD-Website?style=social">
	</a>
</p>

<br>
<br>

### <h1 align="center"> Global dashboard for monitoring Corona virus (COVID-19)</h1>

<p align="center">
    Powered by StickyBoard & Docker
</p>

<p align="center" style="justify-content: space-between">
        	<img width="130" height="150" src="https://github.com/soaple/stickyboard/blob/master/src/static/image/StickyBoard_logo.png?raw=true" alt="stickyboard">
		<img width="160" height="150" src="https://logo-logos.com/wp-content/uploads/2016/10/Docker_logo.png" alt="docker">
</p>

## Build & Run

#### Prerequisite

```bsh
$ npm install -g nodemon
$ npm install
```

### Dockerize

##### Build docker image

Enable [Docker Buildkit](https://docs.docker.com/develop/develop-images/build_enhancements/#to-enable-buildkit-builds) to speed up build

```bsh
$ DOCKER_BUILDKIT=1 docker build -t <dockerhub_username>/<dockerhub_repo_name>:latest .
```

##### Run

```bsh
$ docker run -p 3000:3000 <dockerhub_username>/<dockerhub_repo_name>:latest
```

##### Push docker image to DockerHub

```bsh
$ docker push <dockerhub_username>/<dockerhub_repo_name>:latest
```

#### Development Mode

```bsh
$ npm run watch
$ npm run dev
```

#### Production Mode

```bsh
$ npm run build
$ npm run production
```

## Dev Team

<table align="center">
<tbody>
  <tr>
    <td align="center" valign="top" width="11%">
      <a href="https://github.com/badjio">
        <img
          alt="Backend Developer"
          src="https://avatars2.githubusercontent.com/u/15873766?s=400&v=4"
          style="border-radius: 50px"
          width="100"
          height="100"
        />
        <br />
        <br />
        <i>Moh Badjah</i>
        <br />
      </a>
      <i>Backend Developer</i>
    </td>
    <td align="center" valign="top" width="11%">
      <a href="https://github.com/na6im">
        <img
          alt="Web Developer"
          src="https://avatars1.githubusercontent.com/u/38627023?s=400&v=4"
          style="border-radius: 50px"
          width="100"
          height="100"
        />
        <br />
        <br />
        <i>Nassim Amokrane</i>
        <br />
      </a>
      <i>Web Developer</i>
    </td>
    <td align="center" valign="top" width="11%">
      <a href="https://github.com/MedRedha">
        <img
          alt="Mobile Developer"
          src="https://github.com/medredha.png?s=75"
          style="border-radius: 50px"
          width="100"
          height="100"
        />
        <br />
        <br />
        <i>Med Redha</i>
        <br />
      </a>
      <i>Mobile Developer</i>
    </td>
  </tr>
</tbody>
</table>

## Attribution

-   Global Corona Dashboard powered by [StickyBoard](https://github.com/soaple/stickyboard/)
-   API deployed and operated by [Ainize](https://ainize.ai/laeyoung/wuhan-coronavirus-api)
-   Data provided by [JHU CSSE](https://github.com/CSSEGISandData/COVID-19)

## Contributing to CoronApp

Contributing to CoronApp is a piece of :cake:, read the [contributing guidelines](https://github.com/MedRedha/CoronApp/blob/master/.github/CONTRIBUTING.md). You can discuss CoronApp using the [issues section](https://github.com/MedRedha/CoronApp/issues/new). To add a line create an issue and send a pull request, see [how to send a pull request](https://github.com/MedRedha/CoronApp/blob/master/.github/CONTRIBUTING.md).

## License

The code is available under the [MIT](https://github.com/MedRedha/CoronApp/blob/master/LICENSE) license.

###### [WuuD®](http://wuud.net/) - In code we trust -
