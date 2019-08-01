import {registerBlockType} from '@wordpress/blocks';
import {createElement} from '@wordpress/element';
import {RichText} from '@wordpress/editor';
import {Button} from '@wordpress/components';
import HeaderTab from './Components/Header/Tab';

registerBlockType(
    'mcb/tab-panel-amp',
    {
        title: 'Tab panel',
        icon: 'smiley',
        category: 'common',
        attributes: {
            index: {
                type: 'string',
                default: Math.random().toString(36).substring(2),
                source: 'attribute',
                attribute: 'id',
                selector: 'section'
            },
            tabs: {
                type: 'array',
                default: [],
                source: 'query',
                selector: 'amp-selector > .content',
                query: {
                    index: {
                        type: 'number',
                        source: 'attribute',
                        attribute: 'data-index'
                    },
                    title: {
                        type: 'string',
                        source: 'attribute',
                        attribute: 'data-title'
                    },
                    content: {
                        type: 'string',
                        source: 'text'
                    }
                }
            }
        },

        edit: ({attributes, setAttributes, className}) => {
            console.log(attributes);

            let button = createElement(
                Button,
                {
                    onClick: () => {
                        setAttributes({
                            tabs: [].concat(
                                attributes.tabs.slice(0),
                                {
                                    index: Math.random().toString(36).substring(2),
                                    title: '',
                                    content: ''
                                }
                            )
                        })
                    }
                },
                'Add row'
            );


            let headers = [];
            let elements = attributes.tabs.map((item, key) => {
                headers.push(
                    createElement(
                        'div',
                        {

                        },
                        createElement(
                            RichText,
                            {
                                className: 'title',
                                tagName: 'h3',
                                value: item.title,
                                autoFocus: true,
                                placeholder: 'Tab title goes here...',
                                ...(key > 0 && {disabled: ''}),
                                onChange: value => {
                                    setAttributes({
                                        tabs: attributes.tabs.map(el => {
                                            if (el.index === item.index) {
                                                el.title = value;
                                            }

                                            return el;
                                        })
                                    })
                                }
                            }
                        ),
                        createElement(
                            Button,
                            {
                                onClick: () => {
                                    setAttributes({
                                        tabs: attributes.tabs.filter(el => el.index !== item.index)
                                    });
                                }
                            },
                            '✕'
                        )
                    )
                );

                return createElement(
                    RichText,
                    {
                        className: 'content',
                        tagName: 'p',
                        value: item.content,
                        placeholder: 'Tab content goes here...',
                        onChange: value => {
                            setAttributes({
                                tabs: attributes.tabs.map(el => {
                                    if (el.index === item.index) {
                                        el.content = value;
                                    }

                                    return el;
                                })
                            })
                        }
                    }
                )
            });

            return createElement(
                'div',
                {className: className},
                createElement(
                    'div',
                    {className: 'headers'},
                    headers,
                    button
                ),
                createElement(
                    'div',
                    {className: 'elements'},
                    elements
                )
            )
        },

        save: ({attributes}) => {
            let headers = [];
            let elements = attributes.tabs.map((el, key) => {
                headers.push(
                    createElement(
                        'div',
                        {
                            id: `tab-${attributes.index}-${el.index}`,
                            role: 'tab',
                            'aria-controls': `tabpanel-${attributes.index}-${el.index}`,
                            option: key,
                            ...(key === 0 && {selected: ''})
                        },
                        el.title
                    )
                );

                return createElement(
                    'div',
                    {
                        className:'content',
                        id: `tabpanel-${attributes.index}-${el.index}`,
                        role: 'tabpanel',
                        'aria-labelledby': `tab-${attributes.index}-${el.index}`,
                        'data-title': el.title,
                        'data-index': el.index,
                        option: '',
                        ...(key === 0 && {selected: ''})
                    },
                    el.content
                )
            });

            return createElement(
                'section',
                {
                    id: attributes.index,
                },
                createElement(
                    'amp-selector',
                    {
                        className: 'tabs-with-selector',
                        id: `selector-header-${attributes.index}`,
                        role: 'tablist',
                        on: `select:selector-${attributes.index}.toggle(index=event.targetOption, value=true)`
                    },
                    headers
                ),
                createElement(
                    'amp-selector',
                    {
                        className: 'tabpanels',
                        id: `selector-${attributes.index}`
                    },
                    elements
                )
            )
        }
    }
);
