/*
 * Copyright (c) 2012, Peter Michaux, http://peter.michaux.ca/
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 
 * 1. Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer. 
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution. 
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF
 * THE POSSIBILITY OF SUCH DAMAGE.
 */

// The steps mentioned in the comments below are the steps 
// as described in the ECMAScript 5 specification.
//
// The somewhat unusual variable names match also match the names
// used in the ECMAScript 5 spec.

(function() {
        
    function ToInteger(inputArg) {

        // step 1
        var number = Number(inputArg);

        // step 2
        if (isNaN(number)) {
            return 0;
        }

        // step 3
        if (0 === number || Infinity === number || -Infinity === number) {
            return number;
        }

        // step 4
        return (number < 0 ? -1 : 1) * Math.floor(Math.abs(number));
    }
    
    
    if (!Array.prototype.indexOf) {

        Array.prototype.indexOf = function(searchElement /*, fromIndex */) {

            // step 1
            if (this == null) {
                throw new TypeError("can't convert " + this + " to object");
            }
            var O = Object(this);

            // steps 2 & 3
            var len = O.length >>> 0;

            // step 4
            if (len === 0) {
                return -1;
            }

            // step 5
            var n = (arguments.length > 1) ? ToInteger(arguments[1]) : 0;

            // step 6
            if (n >= len) {
                return -1;
            }

            // step 7
            var k;
            if (n >= 0) {
                k = n;
            }
            // step 8
            else {
                k = len - Math.abs(n);
                if (k < 0) {
                    k = 0;
                }
            }

            // step 9
            while (k < len) {
                if (k in O) {
                    if (searchElement === O[k]) {
                        return k;
                    }
                }
                k++;
            }

            // step 10
            return -1;
        };

    }


    if (!Array.prototype.lastIndexOf) {

        Array.prototype.lastIndexOf = function(searchElement /*, fromIndex */) {

            // step 1
            if (this == null) {
                throw new TypeError("can't convert " + this + " to object");
            }
            var O = Object(this);

            // steps 2 & 3
            var len = O.length >>> 0;

            // step 4
            if (len === 0) {
                return -1;
            }

            // step 5
            var n = (arguments.length > 1) ? ToInteger(arguments[1]) : (len - 1);

            // steps 6 & 7
            var k = (n >= 0) ? 
                        Math.min(n, len-1) : 
                        (len - Math.abs(n));

            // step 8
            while (k >= 0) {
                if ((k in O) && (searchElement === O[k])) {
                    return k;
                }
                k--;
            }

            // step 9
            return -1;
        };

    }


    if (!Array.prototype.every) {

        Array.prototype.every = function(callbackfn /*, thisp */) {

            // step 1
            if (this == null) {
                throw new TypeError("can't convert " + this + " to object");
            }
            var O = Object(this);
        
            // steps 2 & 3
            var len = O.length >>> 0;

            // step 4
            if (typeof callbackfn != "function") {
                throw new TypeError(callbackfn + " is not a function");
            }

            // step 5
            var T = arguments[1];

            // step 6
            var k = 0;

            // step 7
            while (k < len) {
                if ((k in O) && !callbackfn.call(T, O[k], k, O)) {
                    return false;
                }
                k++;
            }
        
            // step 8
            return true;
        };

    }


    if (!Array.prototype.forEach) {

        Array.prototype.forEach = function(callbackfn /*, thisArg */) {

            // step 1
            if (this == null) {
                throw new TypeError("can't convert " + this + " to object");
            }
            var O = Object(this);
        
            // steps 2 & 3
            var len = O.length >>> 0;

            // step 4
            if (typeof callbackfn != "function") {
                throw new TypeError(callbackfn + " is not a function");
            }

            // step 5
            var T = arguments[1];

            // step 6
            var k = 0;
        
            // step 7
            while (k < len) {
                if (k in O) {
                    callbackfn.call(T, O[k], k, O);
                }
                k++;
            }
        
            // step 8
            // return undefined;
        };

    }


    if (!Array.prototype.filter) {

        Array.prototype.filter = function(callbackfn /*, thisArg */) {

            // step 1
            if (this == null) {
                throw new TypeError("can't convert " + this + " to object");
            }
            var O = Object(this);
        
            // steps 2 & 3
            var len = O.length >>> 0;

            // step 4
            if (typeof callbackfn != "function") {
                throw new TypeError(callbackfn + " is not a function");
            }

            // step 5
            var T = arguments[1];

            // step 6
            var A = new Array();

            // step 7
            var k = 0;
        
            // step 8
            var to = 0;
        
            // step 9
            while (k < len) {
                if (k in O) {
                    var kValue = O[k]; // in case callbackfn modifies O[k]
                    if (callbackfn.call(T, kValue, k, O)) {
                        A[to++] = kValue;
                    }
                }
                k++;
            }

            // step 10
            return A;
        };

    }


    if (!Array.prototype.map) {

        Array.prototype.map = function(callbackfn /*, thisArg */) {

            // step 1
            if (this == null) {
                throw new TypeError("can't convert " + this + " to object");
            }
            var O = Object(this);
        
            // steps 2 & 3
            var len = O.length >>> 0;

            // step 4
            if (typeof callbackfn != "function") {
                throw new TypeError(callbackfn + " is not a function");
            }

            // step 5
            var T = arguments[1];

            // step 6
            var A = new Array(len);

            // step 7
            var k = 0;
        
            // step 8
            while (k < len) {
                if (k in O) {
                    A[k] = callbackfn.call(T, O[k], k, O);
                }
                k++;
            }
        
            // step 9        
            return A;
        };

    }


    if (!Array.prototype.some) {

        Array.prototype.some = function(callbackfn /*, thisArg */) {

            // step 1
            if (this == null) {
                throw new TypeError("can't convert " + this + " to object");
            }
            var O = Object(this);
        
            // steps 2 & 3
            var len = O.length >>> 0;

            // step 4
            if (typeof callbackfn != "function") {
                throw new TypeError(callbackfn + " is not a function");
            }

            // step 5
            var T = arguments[1];

            // step 6
            var k = 0;

            // step 7
            while (k < len) {
                if ((k in O) && callbackfn.call(T, O[k], k, O)) {
                    return true;
                }
                k++;
            }

            // step 8
            return false;
        };

    }


    if (!Array.prototype.reduce) {

        Array.prototype.reduce = function(callbackfn /*, initialValue */) {

            // step 1
            if (this == null) {
                throw new TypeError("can't convert " + this + " to object");
            }
            var O = Object(this);

            // steps 2 & 3
            var len = O.length >>> 0;

            // step 4
            if (typeof callbackfn != "function") {
                throw new TypeError(callbackfn + " is not a function");
            }

            // step 5
            if (len === 0 && arguments.length < 2) {
                throw new TypeError('reduce of empty array with no initial value');
            }
        
            // step 6
            var k = 0;

            // step 7
            var accumulator;
            if (arguments.length > 1) {
                accumulator = arguments[1];
            }
            // step 8
            else {
                var kPresent = false;
                while ((!kPresent) && (k < len)) {
                    kPresent = k in O;
                    if (kPresent) {
                        accumulator = O[k];
                    }
                    k++;
                }
                if (!kPresent) {
                    throw new TypeError('reduce of empty array with no initial value');
                }
            }

            // step 9
            while (k < len) {
                if (k in O) {
                    accumulator = callbackfn.call(undefined, accumulator, O[k], k, O);
                }
                k++;
            }
        
            // step 10
            return accumulator;
        };

    }


    if (!Array.prototype.reduceRight) {

        Array.prototype.reduceRight = function(callbackfn /*, initialValue */) {

            // step 1
            if (this == null) {
                throw new TypeError("can't convert " + this + " to object");
            }
            var O = Object(this);

            // steps 2 & 3
            var len = O.length >>> 0;

            // step 4
            if (typeof callbackfn != "function") {
                throw new TypeError(callbackfn + " is not a function");
            }

            // step 5
            if (len === 0 && arguments.length < 2) {
                throw new TypeError('reduce of empty array with no initial value');
            }
        
            // step 6
            var k = len-1;

            // step 7
            var accumulator;
            if (arguments.length > 1) {
                accumulator = arguments[1];
            }
            // step 8
            else {
                var kPresent = false;
                while ((!kPresent) && (k >= 0)) {
                    kPresent = k in O;
                    if (kPresent) {
                        accumulator = O[k];
                    }
                    k--;
                }
                if (!kPresent) {
                    throw new TypeError('reduce of empty array with no initial value');
                }
            }

            // step 9
            while (k >= 0) {
                if (k in O) {
                    accumulator = callbackfn.call(undefined, accumulator, O[k], k, O);
                }
                k--;
            }
        
            // step 10
            return accumulator;
        };

    }

}());
