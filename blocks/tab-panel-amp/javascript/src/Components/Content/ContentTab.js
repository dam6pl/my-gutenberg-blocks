import React from 'react';
import {RichText} from "@wordpress/editor";

export default class ContentTab extends React.Component
{
    changeContent(value) {
        this.props.setAttributes({
            tabs: this.props.attributes.tabs.map(el => {
                if (el.hash === this.props.item.hash) {
                    el.content = value;
                }

                return el;
            })
        })
    }

    render() {
        return (
            <div className={this.props.attributes.edit === this.props.index && 'active'}>
                <RichText
                    value={this.props.item.content}
                    placeholder={'Tab content goes here...'}
                    onChange={val => this.changeContent(val)}
                />
            </div>
        )
    }
}