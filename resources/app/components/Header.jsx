import React from 'react';
import NavBarComponent from './NavBarComponent.jsx';
import SiteLogoComponent from './SiteLogoComponent.jsx';

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