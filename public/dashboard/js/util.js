/*
  javascript.util is a port of selected parts of java.util to JavaScript which
  main purpose is to ease porting Java code to JavaScript.
  
  The MIT License (MIT)

  Copyright (C) 2011-2014 by The Authors

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
*/

(function() {
    var e = this;
    function f(a, b) {
        var c = a.split("."),
            d = e;
        c[0] in d || !d.execScript || d.execScript("var " + c[0]);
        for (var u; c.length && (u = c.shift()); )
            c.length || void 0 === b
                ? d[u]
                    ? (d = d[u])
                    : (d = d[u] = {})
                : (d[u] = b);
    }
    function g(a, b) {
        function c() {}
        c.prototype = b.prototype;
        a.l = b.prototype;
        a.prototype = new c();
        a.prototype.constructor = a;
        a.k = function(a, c, Q) {
            for (
                var K = Array(arguments.length - 2), B = 2;
                B < arguments.length;
                B++
            )
                K[B - 2] = arguments[B];
            return b.prototype[c].apply(a, K);
        };
    }
    function h() {}
    f("javascript.util.Iterator", h);
    h.prototype.hasNext = h.prototype.b;
    h.prototype.next = h.prototype.c;
    h.prototype.remove = h.prototype.a;
    function k(a) {
        this.message = a || "";
    }
    g(k, Error);
    f("javascript.util.OperationNotSupported", k);
    k.prototype.name = "OperationNotSupported";
    function l() {}
    f("javascript.util.Map", l);
    function m() {}
    g(m, l);
    f("javascript.util.SortedMap", m);
    function n(a) {
        this.message = a || "";
    }
    g(n, Error);
    f("javascript.util.IndexOutOfBoundsException", n);
    n.prototype.name = "IndexOutOfBoundsException";
    function p() {}
    f("javascript.util.Collection", p);
    function q() {}
    g(q, p);
    f("javascript.util.Set", q);
    function r() {}
    g(r, q);
    f("javascript.util.SortedSet", r);
    function t(a) {
        this.message = a || "";
    }
    g(t, Error);
    f("javascript.util.EmptyStackException", t);
    t.prototype.name = "EmptyStackException";
    function v() {}
    g(v, p);
    f("javascript.util.List", v);
    function w() {
        this.c = [];
    }
    g(w, v);
    f("javascript.util.Stack", w);
    w.prototype.push = function(a) {
        this.c.push(a);
        return a;
    };
    w.prototype.push = w.prototype.push;
    w.prototype.d = function() {
        if (0 === this.c.length) throw new t();
        return this.c.pop();
    };
    w.prototype.pop = w.prototype.d;
    w.prototype.g = function() {
        if (0 === this.c.length) throw new t();
        return this.c[this.c.length - 1];
    };
    w.prototype.peek = w.prototype.g;
    w.prototype.a = function() {
        return 0 === this.c.length ? !0 : !1;
    };
    w.prototype.empty = w.prototype.a;
    w.prototype.f = function() {
        return this.a();
    };
    w.prototype.isEmpty = w.prototype.f;
    w.prototype.i = function(a) {
        return this.c.indexOf(a);
    };
    w.prototype.search = w.prototype.i;
    w.prototype.b = function() {
        return this.c.length;
    };
    w.prototype.size = w.prototype.b;
    w.prototype.h = function() {
        for (var a = [], b = 0, c = this.c.length; b < c; b++)
            a.push(this.c[b]);
        return a;
    };
    w.prototype.toArray = w.prototype.h;
    function x(a) {
        this.message = a || "";
    }
    g(x, Error);
    f("javascript.util.NoSuchElementException", x);
    x.prototype.name = "NoSuchElementException";
    function y(a) {
        this.a = [];
        a instanceof p && this.d(a);
    }
    g(y, r);
    f("javascript.util.TreeSet", y);
    y.prototype.g = function(a) {
        for (var b = 0, c = this.a.length; b < c; b++)
            if (0 === this.a[b].compareTo(a)) return !0;
        return !1;
    };
    y.prototype.contains = y.prototype.g;
    y.prototype.c = function(a) {
        if (this.g(a)) return !1;
        for (var b = 0, c = this.a.length; b < c; b++)
            if (1 === this.a[b].compareTo(a)) return this.a.splice(b, 0, a), !0;
        this.a.push(a);
        return !0;
    };
    y.prototype.add = y.prototype.c;
    y.prototype.d = function(a) {
        for (a = a.e(); a.b(); ) this.c(a.c());
        return !0;
    };
    y.prototype.addAll = y.prototype.d;
    y.prototype.i = function() {
        throw new k();
    };
    y.prototype.remove = y.prototype.i;
    y.prototype.b = function() {
        return this.a.length;
    };
    y.prototype.size = y.prototype.b;
    y.prototype.f = function() {
        return 0 === this.a.length;
    };
    y.prototype.isEmpty = y.prototype.f;
    y.prototype.h = function() {
        for (var a = [], b = 0, c = this.a.length; b < c; b++)
            a.push(this.a[b]);
        return a;
    };
    y.prototype.toArray = y.prototype.h;
    y.prototype.e = function() {
        return new z(this);
    };
    y.prototype.iterator = y.prototype.e;
    function z(a) {
        this.e = a;
        this.d = 0;
    }
    f("$jscomp.scope.Iterator_", z);
    z.prototype.c = function() {
        if (this.d === this.e.b()) throw new x();
        return this.e.a[this.d++];
    };
    z.prototype.next = z.prototype.c;
    z.prototype.b = function() {
        return this.d < this.e.b() ? !0 : !1;
    };
    z.prototype.hasNext = z.prototype.b;
    z.prototype.a = function() {
        throw new k();
    };
    z.prototype.remove = z.prototype.a;
    function A(a) {
        this.a = [];
        a instanceof p && this.d(a);
    }
    g(A, v);
    f("javascript.util.ArrayList", A);
    A.prototype.c = function(a) {
        this.a.push(a);
        return !0;
    };
    A.prototype.add = A.prototype.c;
    A.prototype.d = function(a) {
        for (a = a.e(); a.b(); ) this.c(a.c());
        return !0;
    };
    A.prototype.addAll = A.prototype.d;
    A.prototype.j = function(a, b) {
        var c = this.a[a];
        this.a[a] = b;
        return c;
    };
    A.prototype.set = A.prototype.j;
    A.prototype.e = function() {
        return new C(this);
    };
    A.prototype.iterator = A.prototype.e;
    A.prototype.g = function(a) {
        if (0 > a || a >= this.b()) throw new n();
        return this.a[a];
    };
    A.prototype.get = A.prototype.g;
    A.prototype.f = function() {
        return 0 === this.a.length;
    };
    A.prototype.isEmpty = A.prototype.f;
    A.prototype.b = function() {
        return this.a.length;
    };
    A.prototype.size = A.prototype.b;
    A.prototype.h = function() {
        for (var a = [], b = 0, c = this.a.length; b < c; b++)
            a.push(this.a[b]);
        return a;
    };
    A.prototype.toArray = A.prototype.h;
    A.prototype.i = function(a) {
        for (var b = !1, c = 0, d = this.a.length; c < d; c++)
            if (this.a[c] === a) {
                this.a.splice(c, 1);
                b = !0;
                break;
            }
        return b;
    };
    A.prototype.remove = A.prototype.i;
    function C(a) {
        this.e = a;
        this.d = 0;
    }
    f("$jscomp.scope.Iterator_$1", C);
    C.prototype.c = function() {
        if (this.d === this.e.b()) throw new x();
        return this.e.g(this.d++);
    };
    C.prototype.next = C.prototype.c;
    C.prototype.b = function() {
        return this.d < this.e.b() ? !0 : !1;
    };
    C.prototype.hasNext = C.prototype.b;
    C.prototype.a = function() {
        throw new k();
    };
    C.prototype.remove = C.prototype.a;
    function D() {
        this.b = {};
    }
    g(D, l);
    f("javascript.util.HashMap", D);
    D.prototype.a = function(a) {
        return this.b[a] || null;
    };
    D.prototype.get = D.prototype.a;
    D.prototype.d = function(a, b) {
        return (this.b[a] = b);
    };
    D.prototype.put = D.prototype.d;
    D.prototype.c = function() {
        var a = new A(),
            b;
        for (b in this.b) this.b.hasOwnProperty(b) && a.c(this.b[b]);
        return a;
    };
    D.prototype.values = D.prototype.c;
    D.prototype.e = function() {
        return this.c().b();
    };
    D.prototype.size = D.prototype.e;
    function E() {}
    f("javascript.util.Arrays", E);
    E.sort = function() {
        var a = arguments[0],
            b,
            c,
            d;
        if (1 === arguments.length) a.sort();
        else if (2 === arguments.length)
            (c = arguments[1]),
                (d = function(a, b) {
                    return c.compare(a, b);
                }),
                a.sort(d);
        else if (3 === arguments.length)
            for (
                b = a.slice(arguments[1], arguments[2]),
                    b.sort(),
                    d = a
                        .slice(0, arguments[1])
                        .concat(b, a.slice(arguments[2], a.length)),
                    a.splice(0, a.length),
                    b = 0;
                b < d.length;
                b++
            )
                a.push(d[b]);
        else if (4 === arguments.length)
            for (
                b = a.slice(arguments[1], arguments[2]),
                    c = arguments[3],
                    d = function(a, b) {
                        return c.compare(a, b);
                    },
                    b.sort(d),
                    d = a
                        .slice(0, arguments[1])
                        .concat(b, a.slice(arguments[2], a.length)),
                    a.splice(0, a.length),
                    b = 0;
                b < d.length;
                b++
            )
                a.push(d[b]);
    };
    E.asList = function(a) {
        for (var b = new A(), c = 0, d = a.length; c < d; c++) b.c(a[c]);
        return b;
    };
    function F(a) {
        this.a = [];
        a instanceof p && this.d(a);
    }
    g(F, q);
    f("javascript.util.HashSet", F);
    F.prototype.g = function(a) {
        for (var b = 0, c = this.a.length; b < c; b++)
            if (this.a[b] === a) return !0;
        return !1;
    };
    F.prototype.contains = F.prototype.g;
    F.prototype.c = function(a) {
        if (this.g(a)) return !1;
        this.a.push(a);
        return !0;
    };
    F.prototype.add = F.prototype.c;
    F.prototype.d = function(a) {
        for (a = a.e(); a.b(); ) this.c(a.c());
        return !0;
    };
    F.prototype.addAll = F.prototype.d;
    F.prototype.i = function() {
        throw new k();
    };
    F.prototype.remove = F.prototype.i;
    F.prototype.b = function() {
        return this.a.length;
    };
    F.prototype.size = F.prototype.b;
    F.prototype.f = function() {
        return 0 === this.a.length;
    };
    F.prototype.isEmpty = F.prototype.f;
    F.prototype.h = function() {
        for (var a = [], b = 0, c = this.a.length; b < c; b++)
            a.push(this.a[b]);
        return a;
    };
    F.prototype.toArray = F.prototype.h;
    F.prototype.e = function() {
        return new G(this);
    };
    F.prototype.iterator = F.prototype.e;
    function G(a) {
        this.e = a;
        this.d = 0;
    }
    f("$jscomp.scope.Iterator_$2", G);
    G.prototype.c = function() {
        if (this.d === this.e.b()) throw new x();
        return this.e.a[this.d++];
    };
    G.prototype.next = G.prototype.c;
    G.prototype.b = function() {
        return this.d < this.e.b() ? !0 : !1;
    };
    G.prototype.hasNext = G.prototype.b;
    G.prototype.a = function() {
        throw new k();
    };
    G.prototype.remove = G.prototype.a;
    function H(a) {
        return null == a ? null : a.parent;
    }
    function I(a, b) {
        null !== a && (a.color = b);
    }
    function J(a) {
        return null == a ? null : a.left;
    }
    function L(a) {
        return null == a ? null : a.right;
    }
    function M() {
        this.b = null;
        this.f = 0;
    }
    g(M, m);
    f("javascript.util.TreeMap", M);
    M.prototype.a = function(a) {
        for (var b = this.b; null !== b; ) {
            var c = a.compareTo(b.key);
            if (0 > c) b = b.left;
            else if (0 < c) b = b.right;
            else return b.value;
        }
        return null;
    };
    M.prototype.get = M.prototype.a;
    M.prototype.d = function(a, b) {
        if (null === this.b)
            return (
                (this.b = {
                    key: a,
                    value: b,
                    left: null,
                    right: null,
                    parent: null,
                    color: 0
                }),
                (this.f = 1),
                null
            );
        var c = this.b,
            d,
            u;
        do
            if (((d = c), (u = a.compareTo(c.key)), 0 > u)) c = c.left;
            else if (0 < u) c = c.right;
            else return (d = c.value), (c.value = b), d;
        while (null !== c);
        c = { key: a, left: null, right: null, value: b, parent: d, color: 0 };
        0 > u ? (d.left = c) : (d.right = c);
        for (c.color = 1; null != c && c != this.b && 1 == c.parent.color; )
            H(c) == J(H(H(c)))
                ? ((d = L(H(H(c)))),
                  1 == (null == d ? 0 : d.color)
                      ? (I(H(c), 0), I(d, 0), I(H(H(c)), 1), (c = H(H(c))))
                      : (c == L(H(c)) && ((c = H(c)), N(this, c)),
                        I(H(c), 0),
                        I(H(H(c)), 1),
                        O(this, H(H(c)))))
                : ((d = J(H(H(c)))),
                  1 == (null == d ? 0 : d.color)
                      ? (I(H(c), 0), I(d, 0), I(H(H(c)), 1), (c = H(H(c))))
                      : (c == J(H(c)) && ((c = H(c)), O(this, c)),
                        I(H(c), 0),
                        I(H(H(c)), 1),
                        N(this, H(H(c)))));
        this.b.color = 0;
        this.f++;
        return null;
    };
    M.prototype.put = M.prototype.d;
    M.prototype.c = function() {
        var a = new A(),
            b;
        b = this.b;
        if (null != b) for (; null != b.left; ) b = b.left;
        if (null !== b) for (a.c(b.value); null !== (b = P(b)); ) a.c(b.value);
        return a;
    };
    M.prototype.values = M.prototype.c;
    function N(a, b) {
        if (null != b) {
            var c = b.right;
            b.right = c.left;
            null != c.left && (c.left.parent = b);
            c.parent = b.parent;
            null == b.parent
                ? (a.b = c)
                : b.parent.left == b
                ? (b.parent.left = c)
                : (b.parent.right = c);
            c.left = b;
            b.parent = c;
        }
    }
    function O(a, b) {
        if (null != b) {
            var c = b.left;
            b.left = c.right;
            null != c.right && (c.right.parent = b);
            c.parent = b.parent;
            null == b.parent
                ? (a.b = c)
                : b.parent.right == b
                ? (b.parent.right = c)
                : (b.parent.left = c);
            c.right = b;
            b.parent = c;
        }
    }
    function P(a) {
        if (null === a) return null;
        if (null !== a.right)
            for (var b = a.right; null !== b.left; ) b = b.left;
        else
            for (b = a.parent; null !== b && a === b.right; )
                (a = b), (b = b.parent);
        return b;
    }
    M.prototype.e = function() {
        return this.f;
    };
    M.prototype.size = M.prototype.e;
})();
