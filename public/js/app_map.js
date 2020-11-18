/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app_map.js":
/*!*********************************!*\
  !*** ./resources/js/app_map.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(init);

function map() {
  var _long = document.getElementById("lo").textContent;
  var lat = document.getElementById("la").textContent;
  mapboxgl.accessToken = 'pk.eyJ1IjoiZ2Ficmk4OCIsImEiOiJja2djd21wMGwwdjJiMnhxZmNpejZ3cTlxIn0.BMNLGIm4EjraujV6Y2ZbVQ';
  var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [_long, lat],
    zoom: 15
  });
  map.addControl(new mapboxgl.FullscreenControl());
  map.on('load', function () {
    var bins = 16;
    var maxHeight = 200;
    var binWidth = maxHeight / bins; // Divide the buildings into 16 bins based on their true height, using a layer filter.

    for (var i = 0; i < bins; i++) {
      map.addLayer({
        'id': '3d-buildings-' + i,
        'source': 'composite',
        'source-layer': 'building',
        'filter': ['all', ['==', 'extrude', 'true'], ['>', 'height', i * binWidth], ['<=', 'height', (i + 1) * binWidth]],
        'type': 'fill-extrusion',
        'minzoom': 15,
        'paint': {
          'fill-extrusion-color': '#aaa',
          'fill-extrusion-height-transition': {
            duration: 0,
            delay: 0
          },
          'fill-extrusion-opacity': 0.6
        }
      });
    } // Older browsers might not implement mediaDevices at all, so we set an empty object first


    if (navigator.mediaDevices === undefined) {
      navigator.mediaDevices = {};
    } // Some browsers partially implement mediaDevices. We can't just assign an object
    // with getUserMedia as it would overwrite existing properties.
    // Here, we will just add the getUserMedia property if it's missing.


    if (navigator.mediaDevices.getUserMedia === undefined) {
      navigator.mediaDevices.getUserMedia = function (constraints) {
        // First get ahold of the legacy getUserMedia, if present
        var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia; // Some browsers just don't implement it - return a rejected promise with an error
        // to keep a consistent interface

        if (!getUserMedia) {
          return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
        } // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise


        return new Promise(function (resolve, reject) {
          getUserMedia.call(navigator, constraints, resolve, reject);
        });
      };
    }

    navigator.mediaDevices.getUserMedia({
      audio: true
    }).then(function (stream) {
      // Set up a Web Audio AudioContext and AnalyzerNode, configured to return the
      // same number of bins of audio frequency data.
      var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
      var analyser = audioCtx.createAnalyser();
      analyser.minDecibels = -90;
      analyser.maxDecibels = -10;
      analyser.smoothingTimeConstant = 0.85;
      var source = audioCtx.createMediaStreamSource(stream);
      source.connect(analyser);
      analyser.fftSize = bins * 2;
      var dataArray = new Uint8Array(bins);

      function draw(now) {
        analyser.getByteFrequencyData(dataArray); // Use that data to drive updates to the fill-extrusion-height property.

        var avg = 0;

        for (var i = 0; i < bins; i++) {
          avg += dataArray[i];
          map.setPaintProperty('3d-buildings-' + i, 'fill-extrusion-height', 10 + 4 * i + dataArray[i]);
        }

        avg /= bins; // Animate the map bearing and light color over time, and make the light more
        // intense when the audio is louder.

        map.setBearing(now / 500);
        map.setLight({
          color: 'hsl(' + now / 100 % 360 + ',' + Math.min(50 + avg / 4, 100) + '%,50%)',
          intensity: Math.min(1, avg / 256 * 10)
        });
        requestAnimationFrame(draw);
      }

      requestAnimationFrame(draw);
    })["catch"](function (err) {
      console.log('The following gUM error occured: ' + err);
    });
  });
  var marker = new mapboxgl.Marker().setLngLat([_long, lat]).addTo(map);
}

function init() {
  map();
}

/***/ }),

/***/ 1:
/*!***************************************!*\
  !*** multi ./resources/js/app_map.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\enric\Desktop\boolBnb\resources\js\app_map.js */"./resources/js/app_map.js");


/***/ })

/******/ });