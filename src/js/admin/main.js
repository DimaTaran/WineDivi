// Import styles if needed
// import '../scss/main.scss';
//
// Example main script
document.addEventListener('DOMContentLoaded', () => {
    const { createElement: el } = wp.element;

    console.log('Main Admin script loaded');

    wp.blocks.registerBlockType('wine/wine-counter', {
        title: 'Numbers of Wine from js file',
        category: 'common',
        edit() {
            return wp.element.createElement(
                'p',
                { className: 'wine-counter' },
                'Numbers of Wine Content from js file'
            );
        },
        save() {
            return wp.element.createElement(
                'p',
                { className: 'wine-counter' },
                'Numbers of Wine Content from js file'
            );
        }
    });



    wp.blocks.registerBlockType('wine/wine-stats', {
        title: 'Wine Stats Section',
        category: 'common',

        edit() {
            return renderBlock();
        },

        save() {
            return renderBlock();
        }
    });

    function renderBlock() {
        // https://www.non-alcoholic-wines.in.ua/wp-content/uploads/2026/03/red-wine-stats.jpg
        const data = {
            stats:  [
                {
                    number: '58871',
                    label: 'пляшок',
                    type: 'Червоних вин',
                    bg: 'https://www.non-alcoholic-wines.in.ua/wp-content/uploads/2026/03/red-wine-stats.jpg'
                },
                {
                    number: '61138',
                    label: 'пляшок',
                    type: 'Білих вин',
                    bg: 'https://www.non-alcoholic-wines.in.ua/wp-content/uploads/2026/03/white-wine-stat.jpg'
                },
                {
                    number: '19803',
                    label: 'пляшок',
                    type: 'Рожевих вин',
                    bg: 'https://www.non-alcoholic-wines.in.ua/wp-content/uploads/2026/03/rose-wine-stat.jpg'
                },
                {
                    number: '65743',
                    label: 'пляшок',
                    type: 'Ігристих вин',
                    bg: 'https://www.non-alcoholic-wines.in.ua/wp-content/uploads/2026/03/sparkling-wine-stat.jpg'
                }
            ],
            title :  'Ми продали 104295 пляшок с серпня 2013 року'
        }

        const statCards = data.stats.map(({ number, label, type, bg }) =>
            el('div', { className: 'stat-card' },
                el('div', {
                    className: 'stat-card-bg',
                    style: { backgroundImage: `url('${bg}')` }
                }),
                el('div', { className: 'stat-card-overlay' }),
                el('div', { className: 'stat-card-content' },
                    el('p', { className: 'stat-number' }, number),
                    el('p', { className: 'stat-label' }, label),
                    el('p', { className: 'stat-type' }, type)
                )
            )
        );

        return el('section', { className: 'wine-stats-section' },
                el('h2', { className: 'main-title' },
                    'Мы продали 104295 вин с августа 2013 года'
                ),
                el('div', { className: 'stats-grid' },
                    ...statCards
                )
        );
    }

});