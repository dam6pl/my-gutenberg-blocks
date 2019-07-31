import {registerBlockType} from '@wordpress/blocks';
import {createElement} from '@wordpress/element';
import Tabs from './Components/Tabs';

registerBlockType(
    'mcb/tab-panel-amp',
    {
        title: 'Tab panel',
        icon: 'smiley',
        category: 'common',
        attributes: {
            hash: {
                type: 'string'
            },
            tabs: {
                type: 'array',
                default: [],
                query: {
                    hash: {
                        type: 'number'
                    },
                    title: {
                        type: 'string'
                    },
                    content: {
                        type: 'string'
                    }
                }
            },
            edit: {
                type: 'number',
                default: 0
            }
        },

        edit: ({attributes, setAttributes, className}) => {
            setAttributes({hash: attributes.hash || Math.random().toString(36).substring(2)});

            return createElement(
                Tabs,
                {
                    attributes: attributes,
                    setAttributes: setAttributes,
                    className: className
                }
            )
        },

        save: () => null
    }
);
