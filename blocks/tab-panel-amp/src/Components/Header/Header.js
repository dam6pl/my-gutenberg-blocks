import React from 'react';
import {Button} from '@wordpress/components';
import HeaderTab from "./HeaderTab";

export default class Header extends React.Component
{
    addRow() {
        this.props.setAttributes({
            tabs: [].concat(
                this.props.attributes.tabs.slice(0),
                {
                    hash: Math.random().toString(36).substring(2),
                    title: '',
                    content: ''
                }
            ),
            edit: this.props.attributes.tabs.length
        })
    }

    render() {
        return (
            <div className="headers">
                {this.props.attributes.tabs.map((tab, i) => {
                    return (
                        <HeaderTab
                            attributes={this.props.attributes}
                            setAttributes={this.props.setAttributes}
                            item={tab}
                            index={i}
                        />
                    )
                })}
                <Button onClick={() => this.addRow()}>Add new</Button>
            </div>
        )
    }
}