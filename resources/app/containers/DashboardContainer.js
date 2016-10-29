/**
 * DashboardContainer
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import MyTodo from './../components/MyTodo';
import {connect} from 'react-redux';
import * as todoActions from './../actions/todoActions';

class DashboardContainer extends React.Component {
  componentDidMount() {
    this.props.getTodos();
  }

  render() {
    return (
      <MyTodo items={this.props.todos}
              visibilityFilter={this.props.visibilityFilter}
              addTodo={this.props.addTodo}
              toggleCompleted={this.props.toggleCompleted}
              setVisibilityFilter={this.props.setVisibilityFilter}
              resetTodo={this.props.resetTodo}
              loading={this.props.loading}/>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    todos: state.todos,
    visibilityFilter: state.visibilityFilter,
    auth: state.auth,
    loading: !state.loading.completed
  }
};

const mapDispatchToProps = (dispatch) => {
  return {
    getTodos: () => {
      dispatch(todoActions.getTodos());
    },
    addTodo: (e) => {
      e.preventDefault();
      var todoName = $("#todo_name");

      dispatch(todoActions.insertTodo(todoName.val()));
      todoName.val('');
    },
    toggleCompleted: (e) => {
      var id = $(e.target).closest("input").attr('id');
      dispatch(todoActions.toggleTodo(id));
      dispatch(todoActions.toggleCompleted(id));
    },
    setVisibilityFilter: (e) => {
      var filter = $(e.target).closest("button").attr('id');
      dispatch(todoActions.setVisibilityFilter(filter));
    },
    resetTodo: () => {
      dispatch(todoActions.deleteTodos());
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(DashboardContainer);