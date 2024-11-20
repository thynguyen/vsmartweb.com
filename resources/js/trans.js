module.exports = {
    methods: {
        /**
         * Translate the given key.
         */
        trans(string, replace) { //string = type,key
            let translation, translationNotFound = true;
            arraykey = string.split('::');
            try {
                if (arraykey[0] === 'Langcore') {
                    packlang = window._translations[window._locale].php.Langcore;
                } else if (arraykey[0] === 'Modlang') {
                    packlang = window._translations[window._locale].php.Modlang;
                } else if (arraykey[0] === 'Lrvlang') {
                    packlang = window._translations[window._locale].php.Lrvlang;
                }
                translation = arraykey[1].split('.').reduce((t, i) => t[i] || null, packlang)
                

                if (translation) {
                    translationNotFound = false
                }
            } catch (e) {
                translation = arraykey[1]
            }

            if (translationNotFound) {
                translation = window._translations[window._locale]['json'][arraykey[1]]
                    ? window._translations[window._locale]['json'][arraykey[1]]
                    : arraykey[1]
            }

            _.forEach(replace, (value, key) => {
                translation = translation.replace(':' + key, value)
            })

            return translation
        }
    },
}