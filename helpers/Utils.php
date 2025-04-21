<?php
class Utils
{
    public static function deleteSession($name)
    {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
        return $name;
    }

    // Si no hay una sesión iniciada como usuario, redirige a la página de login
    public static function isIdentity()
    {
        if (!isset($_SESSION['identity'])) {
            header('Location:' . base_url);
        } else {
            return true;
        }
    }

    //TODO: MEterselo a todas las páginas que correspondan
    public static function requireLogin()
    {
        if (isset($_SESSION['identity'])) {
            header('Location:' . base_url);
            exit();
        } else {
            return true;
        }
    }

    //TODO: require admin
    //TODO: require author
    //Una funcion que verifique

    // Redirigir



    public static function obtenerFraseLiterariaAleatoria()
    {
        $frases = [
            // Literatura clásica
            "Ser o no ser, esa es la cuestión. — William Shakespeare, Hamlet",
            "Todos los animales son iguales, pero algunos animales son más iguales que otros. — George Orwell, Rebelión en la granja",
            "En un lugar de la Mancha, de cuyo nombre no quiero acordarme... — Miguel de Cervantes, Don Quijote de la Mancha",
            "Es una verdad universalmente aceptada que un hombre soltero en posesión de una gran fortuna necesita una esposa. — Jane Austen, Orgullo y prejuicio",
            "Llamadme Ismael. — Herman Melville, Moby-Dick",
            "Era el mejor de los tiempos, era el peor de los tiempos... — Charles Dickens, Historia de dos ciudades",
            "Las personas libres jamás podrán concebir lo que los libros significan para quienes vivimos encerrados. — Anne Frank, El diario de Ana Frank",
            "He amado a las estrellas con demasiado cariño como para tenerle miedo a la noche. — Sarah Williams",
            "El infierno son los otros. — Jean-Paul Sartre, A puerta cerrada",
            "Los sueños pertenecen a aquellos que creen en la belleza de sus ideales. — Eleanor Roosevelt",
            "La historia la escriben los vencedores. — George Orwell, 1984",
            "No hay ninguna barrera, cerradura ni cerrojo que puedas imponer a la libertad de mi mente. — Virginia Woolf",
            "No llores porque terminó, sonríe porque sucedió. — Dr. Seuss",
            "No vemos las cosas como son, las vemos como somos nosotros. — Anaïs Nin",
            "No hay mayor agonía que llevar una historia no contada dentro de ti. — Maya Angelou",
            "El hombre es el único animal que tropieza dos veces con la misma piedra. — Proverbio popular",
            "Cuando miras largo tiempo a un abismo, el abismo también mira dentro de ti. — Friedrich Nietzsche",
            "La vida es lo que pasa mientras estás ocupado haciendo otros planes. — John Lennon",
            "Lo esencial es invisible a los ojos. — Antoine de Saint-Exupéry, El Principito",
            "El corazón tiene razones que la razón no entiende. — Blaise Pascal",
            "El conocimiento es poder. — Francis Bacon",
            "Pienso, luego existo. — René Descartes",
            "El que lee mucho y anda mucho, ve mucho y sabe mucho. — Miguel de Cervantes",
            "No hay medicina que cure lo que no cura la felicidad. — Gabriel García Márquez",
            "La lectura es una conversación con los hombres más sabios de los siglos pasados. — René Descartes",
            "La literatura es la prueba de que la vida no alcanza. — Fernando Pessoa",
            "La pluma es más poderosa que la espada. — Edward Bulwer-Lytton",
            "El hombre que no lee no tiene ninguna ventaja sobre el hombre que no sabe leer. — Mark Twain",
            "Quien tiene un porqué para vivir, puede soportar casi cualquier cómo. — Friedrich Nietzsche",
            "Todos nacemos originales y morimos copias. — Carl Jung",
            "El alma que hablar puede con los ojos, también puede besar con la mirada. — Gustavo Adolfo Bécquer",
            "La felicidad no está en la posesión del dinero; se encuentra en la alegría del logro. — Franklin D. Roosevelt",
            "Aquel que tiene imaginación, con qué facilidad saca de la nada un mundo. — Gustavo Adolfo Bécquer",
            "Las palabras son, en mi nada humilde opinión, nuestra fuente más inagotable de magia. — J.K. Rowling, Harry Potter",
            "El que domina a los otros es fuerte; el que se domina a sí mismo es poderoso. — Lao-Tse",

            // Brandon Sanderson
            "La vida antes que la muerte, la fuerza antes que la debilidad, el viaje antes que el destino. — El Archivo de las Tormentas",
            "A veces el poder no reside en lo que puedes hacer, sino en lo que decides no hacer. — Nacidos de la Bruma",
            "No hay héroes que no tengan grietas; lo que importa es lo que hacen a pesar de ellas. — El Camino de los Reyes",
            "La lógica falla frente a una fe determinada. — Elantris",
            "Los hombres no eran dioses. Pero a veces, los dioses eran hombres. — El Imperio Final"
        ];

        return $frases[array_rand($frases)];
    }
}
