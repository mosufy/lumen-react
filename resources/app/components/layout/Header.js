import React from 'react';
import NavBarComponent from './NavBarComponent';
import SiteLogoComponent from './SiteLogoComponent';

export default class Header extends React.Component {
  render() {
    return (
      <div className="header clearfix">
        <NavBarComponent pageTemplate={this.props.pageTemplate}/>
        <SiteLogoComponent pageTemplate={this.props.pageTemplate}/>
      </div>
    );
  }
}