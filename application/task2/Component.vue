<template>
    <div>
        Strona główna
    </div>

    <div>
        Policz ze mną cyfry od 1 do {{ liczba }}

        <ul>
            <li v-forearch="(wartosc, licz) in liczba">
                {{ licz }}
            </li>
        </ul>

        Teraz pozwól że pomnoże liczbę przez dwa używając computed
        <p>
            Oto wynik: { mnozeRazyDwa * 2 }
        </p>

        Oraz dodam 2 do wyniku mnożenia
        <p>
            Oto wynik: {{ mnozeRazyDwa() + '2' }}
        </p>

        <h4>
            Drzewko ulubionych owoców i warzyw
        </h4>
        <ul>
            <li v-for="galazka,index in drzewo" :index="index">
                {{ galazka[name] }}

                <ul>
                    <li v-for="cos in drzewo.children">
                        {{ cos }}
                    </li>
                </ul>
            </li>
        </ul>
		<form> 
			<button type="submit" onclick="mojaZonaLubi()">Co lubi moja żona ? kliknij a się dowiesz :).</button>
		</form>
    </div>
</template>
<script>

    const $zonyUlubione = [
        {
            name: 'Owoce',
            children: [
                {name: 'Jabuszko'},
                {name: 'Gruszka'}
            ]
        },
        {
            name: 'Warzywa',
            children: [
                {name: 'Cebula'}
            ]
        }
    ];

    export default {
        props: [
            'liczba'
        ],

        data() {
            return {
                liczba: '10',
                jaLubie: [
                    {
                        name: 'Owoce',
                        children: [
                            {name: 'Banan'},
                            {name: 'Mango'}
                        ]
                    },
                    {
                        name: 'Warzywa',
                        children: [
                            {name: 'Marchew'},
                            {name: 'Ziemniak'},
                            {name: 'Burak'}
                        ]
                    }
                ],

                drzewo: []
            };
        },

        mounted() {
            this.$parent.wartoscMnozeniaPrzezDwa = mnozeRazyDwa;
            this.drzewo = this.jaLubie;
        },

        computed: {
            mojaZonaLubi(){
                this.drzewo = this.zonyUlubione;
            }
        },

        methods:
        {
            mnozeRazyDwa(){
                return this.liczba * '2';
            }
        }
    }
</script>