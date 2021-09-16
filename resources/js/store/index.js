import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: null,
        books: [],
        weather: null,
    },
    mutations: {
        addUser(state, user) {
            state.user = user;
        },
        addBooks(state, books) {
            state.books = books;
        },
        addBook(state, book) {
            let newBooks = state.books;
            newBooks = newBooks.filter(newBook => newBook.id !== book.id)
            newBooks.unshift(book);

            state.books = newBooks;
        },
        removeBook(state, book) {
            let newBooks = state.books;
            newBooks = newBooks.filter(newBook => newBook.id !== book.id)

            state.books = newBooks;
        },
        addWeather(state, weather) {
            state.weather = weather;
        },
    },
    getters: {
        user: state => {
            return state.user;
        },
        books: state => {
            return state.books;
        },
        weather: state => {
            return state.weather;
        }
    },
    actions: {
        async login({ commit }, payload) {
            try {
                const { user, token } = (
                    await axios.post("/api/login", payload)
                ).data;

                localStorage.setItem("token", token);

                commit("addUser", user);

                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${token}`;

                return token;
            } catch (err) {
                return false;
            }
        },
        async logout({ commit }) {
            const { token } = (await axios.post("/api/logout")).data;

            localStorage.removeItem("token");
        },
        async me({ commit }) {
            const user = (await axios.get("/api/me")).data;

            commit("addUser", user);
        },
        async fetch({ commit }) {
            const books = (await axios.get("/api/books")).data;

            commit("addBooks", books);
        },
        async create({ commit }, book) {
            let response;

            if (book.id) {
                response = (await axios.put(`/api/books/${book.id}`, book)).data;
            } else {
                response = (await axios.post("/api/books", book)).data;
            }

            commit('addBook', response);
        },
        async delete({ commit }, book) {
            (await axios.delete(`/api/books/${book.id}`)).data;

            commit("removeBook", book);
        },
        async fetchWeather({ commit }) {
            const weather = (await axios.get(`/api/weather`)).data;

            commit("addWeather", weather);
        }
    }
});
